<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;

use App\Services\ProfileService;

class PublicProfileController extends Controller
{
    protected $profileService;

    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    public function show($username)
    {
        // Kullanıcıyı username üzerinden bul, bulamazsa 404 dön
        $user = User::where('username', $username)->firstOrFail();
        
        return $this->renderProfile($user);
    }

    public function showByCustomDomain(Request $request)
    {
        $profile = $request->attributes->get('custom_domain_profile');
        
        if (!$profile) {
            abort(404);
        }

        return $this->renderProfile($profile->user);
    }

    protected function renderProfile(User $user)
    {
        $data = $this->profileService->getProfileData($user);
        
        if (!$data) {
            abort(404);
        }

        $profile = $data['profile'];
        $links = $data['links'];

        // Analytics logging
        $request = request();
        $ua = $request->userAgent();
        $parsedUA = $this->profileService->parseUserAgent($ua);
        
        $this->profileService->logView($profile, [
            'ip' => $request->ip(),
            'device' => substr($ua, 0, 255),
            'country' => $request->header('CF-IPCountry'),
            'browser' => $parsedUA['browser'],
            'os' => $parsedUA['os'],
            'referer' => $request->headers->get('referer'),
        ]);

        return view('public.profile', compact('user', 'profile', 'links'));
    }

    public function redirect(Link $link, Request $request)
    {
        // Link aktif değilse veya kullanıcının profili aktif değilse engelle
        $now = now();
        if (!$link->is_active || 
            ($link->starts_at && $link->starts_at > $now) || 
            ($link->expires_at && $link->expires_at < $now) ||
            !$link->user->profile->is_active) {
            abort(404);
        }

        // Password Protection Check
        if ($link->password) {
            $sessionKey = 'link_verified_' . $link->id;
            if (!session()->has($sessionKey)) {
                return view('public.password-prompt', compact('link'));
            }
        }

        // Tıklama sayısını 1 arttır
        $link->increment('clicks');

        // Analytics helpers
        $ua = $request->userAgent();
        $parsedUA = $this->profileService->parseUserAgent($ua);

        // ClickLog oluştur
        $link->clickLogs()->create([
            'ip' => $request->ip(),
            'device' => substr($ua, 0, 255),
            'country' => $request->header('CF-IPCountry'),
            'browser' => $parsedUA['browser'],
            'os' => $parsedUA['os'],
            'referer' => $request->headers->get('referer'),
        ]);

        return redirect()->away($link->url);
    }

    public function verifyPassword(Link $link, Request $request)
    {
        if ($request->password === $link->password) {
            session(['link_verified_' . $link->id => true]);
            return redirect()->route('public.redirect', $link);
        }

        return back()->withErrors(['password' => 'Hatalı şifre.']);
    }
}
