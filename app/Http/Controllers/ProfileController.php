<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

use App\Services\ProfileService;

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

        if ($user->profile) {
            $profileData = [
                'username' => $user->username,
                'bio' => $request->bio,
                'theme' => $request->input('theme', 'minimal'),
                'theme_type' => $request->input('theme_type', 'preset'),
                'bg_type' => $request->input('bg_type'),
                'bg_color' => $request->input('bg_color'),
                'bg_gradient' => $request->input('bg_gradient'),
                'bg_blur' => $request->input('bg_blur', 0),
                'bg_overlay' => $request->input('bg_overlay', 0),
                'text_color' => $request->input('text_color'),
                'button_color' => $request->input('button_color'),
                'button_text_color' => $request->input('button_text_color'),
                'button_style' => $request->input('button_style', 'rounded'),
                'button_shadow' => $request->has('button_shadow'),
                'font_family' => $request->input('font_family', 'inter'),
                'custom_css' => $request->input('custom_css'),
                'meta_title' => $request->input('meta_title'),
                'meta_description' => $request->input('meta_description'),
                'custom_domain' => $request->input('custom_domain'),
            ];

            // If custom_domain is changed, reset verified status (for now)
            if ($user->profile->custom_domain !== $request->input('custom_domain')) {
                $profileData['custom_domain_verified'] = false;
            }

            // Avatar Upload
            if ($request->hasFile('avatar')) {
                try {
                    if ($user->profile->avatar) {
                        Storage::disk('public')->delete($user->profile->avatar);
                    }

                    $file = $request->file('avatar');
                    $manager = new \Intervention\Image\ImageManager(new \Intervention\Image\Drivers\Gd\Driver());
                    $image = $manager->read($file);
                    $image->scale(512, 512);
                    $encoded = $image->toWebp(80);
                    $filename = 'avatars/' . \Illuminate\Support\Str::random(40) . '.webp';
                    
                    // Ensure directory exists
                    if (!Storage::disk('public')->exists('avatars')) {
                        Storage::disk('public')->makeDirectory('avatars');
                    }
                    
                    Storage::disk('public')->put($filename, (string) $encoded);
                    $profileData['avatar'] = $filename;
                } catch (\Exception $e) {
                    \Log::error('Avatar processing failed: ' . $e->getMessage());
                }
            }

            // Background Image Upload
            if ($request->hasFile('bg_image')) {
                try {
                    if ($user->profile->bg_image) {
                        Storage::disk('public')->delete($user->profile->bg_image);
                    }

                    $file = $request->file('bg_image');
                    $manager = new \Intervention\Image\ImageManager(new \Intervention\Image\Drivers\Gd\Driver());
                    $image = $manager->read($file);
                    
                    // Max height 1080 while maintaining aspect ratio
                    $image->scale(null, 1080);
                    
                    $encoded = $image->toWebp(70); 
                    $filename = 'backgrounds/' . \Illuminate\Support\Str::random(40) . '.webp';
                    
                    // Ensure directory exists
                    if (!Storage::disk('public')->exists('backgrounds')) {
                        Storage::disk('public')->makeDirectory('backgrounds');
                    }
                    
                    Storage::disk('public')->put($filename, (string) $encoded);
                    $profileData['bg_image'] = $filename;
                } catch (\Exception $e) {
                    \Log::error('Background processing failed: ' . $e->getMessage());
                }
            }

            $user->profile->update($profileData);
            $this->profileService->clearProfileCache($user);
        }

        return Redirect::route('dashboard', ['tab' => 'design'])->with('status', 'profile-updated');
    }

    /**
     * Update the user's design settings via AJAX.
     */
    public function updateDesign(Request $request)
    {
        $user = $request->user();
        $designSettings = $request->input('design_settings');
        
        // If it's a standard JSON request (no files)
        if ($request->isJson()) {
            if ($user->profile) {
                // Update basic profile info if provided
                if (isset($designSettings['profile'])) {
                    $user->update(['name' => $designSettings['profile']['name']]);
                    $user->profile->update(['bio' => $designSettings['profile']['bio']]);
                }
                
                $user->profile->update([
                    'design_settings' => $designSettings,
                ]);
                $this->profileService->clearProfileCache($user);
            }
            return response()->json(['success' => true, 'design_settings' => $designSettings]);
        }

        // Handle multipart form-data (for file uploads)
        // design_settings comes as a stringified JSON in FormData
        $designSettings = json_decode($request->input('design_settings'), true);
        $profileData = [];

        if ($user->profile) {
            // Update profile fields
            if (isset($designSettings['profile'])) {
                $user->update(['name' => $designSettings['profile']['name']]);
                $user->profile->update(['bio' => $designSettings['profile']['bio']]);
            }

            // Hero Image
            if ($request->hasFile('hero_image')) {
                try {
                    $file = $request->file('hero_image');
                    $manager = new \Intervention\Image\ImageManager(new \Intervention\Image\Drivers\Gd\Driver());
                    $image = $manager->read($file);
                    $image->scale(1200, null);
                    $encoded = $image->toWebp(80);
                    $filename = 'hero/' . \Illuminate\Support\Str::random(40) . '.webp';
                    
                    if (!Storage::disk('public')->exists('hero')) {
                        Storage::disk('public')->makeDirectory('hero');
                    }
                    
                    Storage::disk('public')->put($filename, (string) $encoded);
                    $designSettings['header']['hero_image_url'] = Storage::url($filename);
                } catch (\Exception $e) {
                    \Log::error('Hero upload failed: ' . $e->getMessage());
                }
            }

            // Background Image
            if ($request->hasFile('bg_image')) {
                try {
                    $file = $request->file('bg_image');
                    $manager = new \Intervention\Image\ImageManager(new \Intervention\Image\Drivers\Gd\Driver());
                    $image = $manager->read($file);
                    $image->scale(1920, null);
                    $encoded = $image->toWebp(70);
                    $filename = 'backgrounds/' . \Illuminate\Support\Str::random(40) . '.webp';
                    
                    if (!Storage::disk('public')->exists('backgrounds')) {
                        Storage::disk('public')->makeDirectory('backgrounds');
                    }
                    
                    Storage::disk('public')->put($filename, (string) $encoded);
                    $designSettings['background']['image_url'] = Storage::url($filename);
                } catch (\Exception $e) {
                    \Log::error('Background upload failed: ' . $e->getMessage());
                }
            }

            // Background Video (Max 5MB)
            if ($request->hasFile('bg_video')) {
                $file = $request->file('bg_video');
                if ($file->getSize() <= 5 * 1024 * 1024) { // 5MB limit
                    $filename = $file->store('videos', 'public');
                    $designSettings['background']['video_url'] = Storage::url($filename);
                }
            }

            $user->profile->update([
                'design_settings' => $designSettings,
            ]);
            $this->profileService->clearProfileCache($user);
        }

        return response()->json(['success' => true, 'design_settings' => $designSettings]);
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
