<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Services\ProfileService;
use App\Support\DesignEditor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
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
        $profile = $this->ensureProfile($user);

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
                $designSettings['header']['hero_image_url'] = $this->storeDesignMedia(
                    'hero_image',
                    $request->file('hero_image'),
                );
            }

            // Background Image
            if ($request->hasFile('bg_image')) {
                $designSettings['background']['image_url'] = $this->storeDesignMedia(
                    'bg_image',
                    $request->file('bg_image'),
                );
            }

            // Background Video
            if ($request->hasFile('bg_video')) {
                $designSettings['background']['video_url'] = $this->storeDesignMedia(
                    'bg_video',
                    $request->file('bg_video'),
                );
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

    public function uploadDesignMedia(Request $request)
    {
        $request->validate([
            'media_type' => ['required', 'in:hero_image,bg_image,bg_video'],
            'file' => ['required', 'file'],
        ]);

        try {
            $url = $this->storeDesignMedia(
                (string) $request->input('media_type'),
                $request->file('file'),
            );

            return response()->json([
                'success' => true,
                'media_type' => $request->input('media_type'),
                'url' => $url,
            ]);
        } catch (\RuntimeException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        } catch (\Throwable $e) {
            Log::error('Design media upload failed: '.$e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Medya yuklemesi sirasinda bir hata olustu.',
            ], 500);
        }
    }

    public function uploadDesignMediaChunk(Request $request)
    {
        $request->validate([
            'media_type' => ['required', 'in:bg_video'],
            'upload_id' => ['required', 'string', 'max:120', 'regex:/^[A-Za-z0-9_-]+$/'],
            'chunk_index' => ['required', 'integer', 'min:0'],
            'total_chunks' => ['required', 'integer', 'min:1', 'max:64'],
            'chunk' => ['required', 'file'],
        ]);

        try {
            $uploadId = $this->sanitizeUploadId((string) $request->input('upload_id'));
            $chunkIndex = (int) $request->input('chunk_index');
            $directory = $this->chunkDirectory($request->user()->id, $uploadId);

            Storage::disk('local')->putFileAs(
                $directory,
                $request->file('chunk'),
                sprintf('%05d.part', $chunkIndex),
            );

            return response()->json([
                'success' => true,
                'upload_id' => $uploadId,
                'chunk_index' => $chunkIndex,
            ]);
        } catch (\Throwable $e) {
            Log::error('Design media chunk upload failed: '.$e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Video parcasi yuklenemedi.',
            ], 500);
        }
    }

    public function finalizeDesignMediaUpload(Request $request)
    {
        $request->validate([
            'media_type' => ['required', 'in:bg_video'],
            'upload_id' => ['required', 'string', 'max:120', 'regex:/^[A-Za-z0-9_-]+$/'],
            'total_chunks' => ['required', 'integer', 'min:1', 'max:64'],
            'original_name' => ['nullable', 'string', 'max:255'],
        ]);

        $directory = null;
        $tempPath = null;

        try {
            $uploadId = $this->sanitizeUploadId((string) $request->input('upload_id'));
            $totalChunks = (int) $request->input('total_chunks');
            $directory = $this->chunkDirectory($request->user()->id, $uploadId);
            $tempDir = storage_path('app/tmp');
            $originalName = basename((string) ($request->input('original_name') ?: 'background.mp4'));
            $tempPath = $tempDir.'/'.Str::random(40).'-'.$originalName;

            if (! Storage::disk('local')->exists($directory)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Yukleme parcasi bulunamadi.',
                ], 422);
            }

            if (! is_dir($tempDir)) {
                mkdir($tempDir, 0755, true);
            }

            $handle = fopen($tempPath, 'wb');

            if ($handle === false) {
                throw new \RuntimeException('Gecici video dosyasi olusturulamadi.');
            }

            for ($index = 0; $index < $totalChunks; $index++) {
                $chunkPath = $directory.'/'.sprintf('%05d.part', $index);

                if (! Storage::disk('local')->exists($chunkPath)) {
                    fclose($handle);

                    return response()->json([
                        'success' => false,
                        'message' => 'Video parcalarinin bir kismi eksik.',
                    ], 422);
                }

                fwrite($handle, Storage::disk('local')->get($chunkPath));
            }

            fclose($handle);

            $uploadedFile = new UploadedFile(
                $tempPath,
                $originalName,
                null,
                null,
                true,
            );

            $url = $this->storeDesignMedia('bg_video', $uploadedFile);

            return response()->json([
                'success' => true,
                'media_type' => 'bg_video',
                'url' => $url,
            ]);
        } catch (\RuntimeException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        } catch (\Throwable $e) {
            Log::error('Design media finalize failed: '.$e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Video birlestirilirken bir hata olustu.',
            ], 500);
        } finally {
            if (is_file($tempPath)) {
                @unlink($tempPath);
            }

            if ($directory) {
                Storage::disk('local')->deleteDirectory($directory);
            }
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

    private function ensureProfile($user)
    {
        return $user->profile ?: $user->profile()->create([
            'username' => $user->username,
        ]);
    }

    private function chunkDirectory(int $userId, string $uploadId): string
    {
        return 'design-media/'.$userId.'/'.$uploadId;
    }

    private function sanitizeUploadId(string $uploadId): string
    {
        $sanitized = preg_replace('/[^A-Za-z0-9_-]/', '', $uploadId) ?: '';

        if ($sanitized === '') {
            throw new \InvalidArgumentException('Gecersiz yukleme kimligi.');
        }

        return $sanitized;
    }

    private function storeDesignMedia(string $mediaType, UploadedFile $file): string
    {
        return match ($mediaType) {
            'hero_image' => $this->storeHeroImage($file),
            'bg_image' => $this->storeBackgroundImage($file),
            'bg_video' => $this->storeBackgroundVideo($file),
            default => throw new \InvalidArgumentException('Unsupported design media type.'),
        };
    }

    private function storeHeroImage(UploadedFile $file): string
    {
        $manager = new ImageManager(new Driver);
        $image = $manager->read($file);
        $image->scale(1200, null);
        $encoded = $image->toWebp(80);
        $filename = 'hero/'.Str::random(40).'.webp';

        if (! Storage::disk('public')->exists('hero')) {
            Storage::disk('public')->makeDirectory('hero');
        }

        Storage::disk('public')->put($filename, (string) $encoded);

        return Storage::url($filename);
    }

    private function storeBackgroundImage(UploadedFile $file): string
    {
        $manager = new ImageManager(new Driver);
        $image = $manager->read($file);
        $image->scale(1920, null);
        $encoded = $image->toWebp(70);
        $filename = 'backgrounds/'.Str::random(40).'.webp';

        if (! Storage::disk('public')->exists('backgrounds')) {
            Storage::disk('public')->makeDirectory('backgrounds');
        }

        Storage::disk('public')->put($filename, (string) $encoded);

        return Storage::url($filename);
    }

    private function storeBackgroundVideo(UploadedFile $file): string
    {
        if ($file->getSize() > 8 * 1024 * 1024) {
            throw new \RuntimeException('Video boyutu 8MB limitini asiyor.');
        }

        $filename = $file->store('videos', 'public');

        return Storage::url($filename);
    }
}
