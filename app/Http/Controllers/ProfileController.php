<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Services\ProfileService;
use App\Support\DesignEditor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class ProfileController extends Controller
{
    protected $profileService;

    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        $user->fill([
            'username' => trim(strtolower($request->username)),
            'name' => $request->name,
            'email' => $request->email,
        ]);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $profile = $user->profile ?: $user->profile()->create([
            'username' => $user->username,
        ]);

        $profileData = [
            'username' => $user->username,
            'bio' => $request->bio,
            'meta_title' => $request->input('meta_title'),
            'meta_description' => $request->input('meta_description'),
            'custom_domain' => $request->input('custom_domain'),
        ];

        if ($profile->custom_domain !== $request->input('custom_domain')) {
            $profileData['custom_domain_verified'] = false;
        }

        if ($request->hasFile('avatar')) {
            try {
                if ($profile->avatar) {
                    Storage::disk('public')->delete($profile->avatar);
                }

                $file = $request->file('avatar');
                $manager = new ImageManager(new Driver);
                $image = $manager->read($file);
                $image->scale(512, 512);
                $encoded = $image->toWebp(80);
                $filename = 'avatars/'.Str::random(40).'.webp';

                if (! Storage::disk('public')->exists('avatars')) {
                    Storage::disk('public')->makeDirectory('avatars');
                }

                Storage::disk('public')->put($filename, (string) $encoded);
                $profileData['avatar'] = $filename;
            } catch (\Exception $e) {
                Log::error('Avatar processing failed: '.$e->getMessage());
            }
        }

        $profileData['design_settings'] = DesignEditor::resolve($profile, [
            'profile' => [
                'name' => $user->name,
                'username' => $user->username,
                'bio' => $request->bio ?? '',
            ],
        ]);

        $profile->update($profileData);
        $this->profileService->clearProfileCache($user);

        return Redirect::route('dashboard', ['tab' => 'design'])->with('status', 'profile-updated');
    }

    /**
     * Update the user's design settings via AJAX.
     */
    public function updateDesign(Request $request)
    {
        $user = $request->user();
        $profile = $user->profile;

        if (! $profile) {
            $profile = $user->profile()->create([
                'username' => $user->username,
            ]);
        }

        try {
            // If it's a standard JSON request (no files)
            if ($request->isJson()) {
                $designSettings = $request->input('design_settings');

                if (! is_array($designSettings)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Invalid design payload.',
                    ], 422);
                }

                if (isset($designSettings['profile'])) {
                    $user->update(['name' => $designSettings['profile']['name'] ?? $user->name]);
                    $profile->update(['bio' => $designSettings['profile']['bio'] ?? $profile->bio]);
                }

                $profile->design_settings = $designSettings;
                $designSettings = DesignEditor::resolve($profile, [
                    'profile' => [
                        'name' => $user->name,
                        'username' => $user->username,
                        'bio' => $profile->bio ?? '',
                    ],
                ]);

                $profile->update([
                    'design_settings' => $designSettings,
                ]);
                $this->profileService->clearProfileCache($user);

                return response()->json(['success' => true, 'design_settings' => $designSettings]);
            }

            // Handle multipart form-data (for file uploads)
            $designSettingsInput = $request->input('design_settings');
            $designSettings = is_string($designSettingsInput) ? json_decode($designSettingsInput, true) : $designSettingsInput;

            if (! is_array($designSettings)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid design payload.',
                ], 422);
            }

            \Log::debug('Design Update Request:', [
                'user_id' => $user->id,
                'has_hero' => $request->hasFile('hero_image'),
                'has_bg' => $request->hasFile('bg_image'),
                'settings' => $designSettings,
            ]);

            // Update profile fields
            if (isset($designSettings['profile'])) {
                $user->update(['name' => $designSettings['profile']['name'] ?? $user->name]);
                $profile->update(['bio' => $designSettings['profile']['bio'] ?? $profile->bio]);
            }

            // Hero Image
            if ($request->hasFile('hero_image')) {
                $file = $request->file('hero_image');
                $manager = new ImageManager(new Driver);
                $image = $manager->read($file);
                $image->scale(1200, null);
                $encoded = $image->toWebp(80);
                $filename = 'hero/'.Str::random(40).'.webp';

                if (! Storage::disk('public')->exists('hero')) {
                    Storage::disk('public')->makeDirectory('hero');
                }

                Storage::disk('public')->put($filename, (string) $encoded);
                $designSettings['header']['hero_image_url'] = Storage::url($filename);
            }

            // Background Image
            if ($request->hasFile('bg_image')) {
                $file = $request->file('bg_image');
                $manager = new ImageManager(new Driver);
                $image = $manager->read($file);
                $image->scale(1920, null);
                $encoded = $image->toWebp(70);
                $filename = 'backgrounds/'.Str::random(40).'.webp';

                if (! Storage::disk('public')->exists('backgrounds')) {
                    Storage::disk('public')->makeDirectory('backgrounds');
                }

                Storage::disk('public')->put($filename, (string) $encoded);
                $designSettings['background']['image_url'] = Storage::url($filename);
            }

            // Background Video
            if ($request->hasFile('bg_video')) {
                $file = $request->file('bg_video');
                if ($file->getSize() <= 8 * 1024 * 1024) { // Increased to 8MB
                    $filename = $file->store('videos', 'public');
                    $designSettings['background']['video_url'] = Storage::url($filename);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Video boyutu 8MB limitini asiyor.',
                    ], 422);
                }
            }

            $profile->design_settings = $designSettings;
            $designSettings = DesignEditor::resolve($profile, [
                'profile' => [
                    'name' => $user->name,
                    'username' => $user->username,
                    'bio' => $profile->bio ?? '',
                ],
            ]);

            $profile->update([
                'design_settings' => $designSettings,
            ]);
            $this->profileService->clearProfileCache($user);

            return response()->json(['success' => true, 'design_settings' => $designSettings]);
        } catch (\Exception $e) {
            \Log::error('Design Update Error: '.$e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}


