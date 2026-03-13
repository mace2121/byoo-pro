<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
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
                'custom_domain' => $request->input('custom_domain'),
            ];

            // If custom_domain is changed, reset verified status (for now)
            if ($user->profile->custom_domain !== $request->input('custom_domain')) {
                $profileData['custom_domain_verified'] = false;
            }

            if ($request->hasFile('avatar')) {
                // Delete old avatar
                if ($user->profile->avatar) {
                    Storage::disk('public')->delete($user->profile->avatar);
                }

                $file = $request->file('avatar');
                $filename = 'avatars/' . \Illuminate\Support\Str::random(40) . '.' . $file->getClientOriginalExtension();

                // Image processing (Resize and Optimize)
                $manager = new \Intervention\Image\ImageManager(
                    new \Intervention\Image\Drivers\Gd\Driver()
                );
                
                $image = $manager->read($file);
                
                // Scale to 512x512 max while maintaining aspect ratio
                $image->scale(512, 512);

                // Encode as webp for better compression if possible, otherwise keep original extension
                $encoded = $image->toWebp(80);
                $filename = 'avatars/' . \Illuminate\Support\Str::random(40) . '.webp';

                Storage::disk('public')->put($filename, (string) $encoded);
                
                $profileData['avatar'] = $filename;
            }

            $user->profile->update($profileData);
        }

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
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
