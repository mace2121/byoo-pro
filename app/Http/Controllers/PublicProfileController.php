<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;

class PublicProfileController extends Controller
{
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
        $profile = $user->profile;
        if (!$profile || !$profile->is_active) {
            abort(404);
        }

        // Görüş sayısını 1 arttır
        $profile->increment('views');

        // Kullanıcının SADECE aktif ve zamanlanmış linklerini, order siralamasına gore getir
        $now = now();
        $links = $user->links()
            ->where('is_active', true)
            ->where(function($query) use ($now) {
                $query->whereNull('starts_at')
                      ->orWhere('starts_at', '<=', $now);
            })
            ->where(function($query) use ($now) {
                $query->whereNull('expires_at')
                      ->orWhere('expires_at', '>=', $now);
            })
            ->orderBy('order')
            ->get();

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

        // Analytics helpers (Simple extraction from User Agent)
        $ua = $request->userAgent();
        $browser = $this->getBrowser($ua);
        $os = $this->getOS($ua);
        $referer = $request->headers->get('referer');

        // Extract IP & Country if available
        $ip = $request->ip();
        $country = $request->header('CF-IPCountry'); 

        // ClickLog oluştur
        $link->clickLogs()->create([
            'ip' => $ip,
            'device' => substr($ua, 0, 255),
            'country' => $country,
            'browser' => $browser,
            'os' => $os,
            'referer' => $referer,
        ]);

        return redirect()->away($link->url);
    }

    protected function getBrowser($ua)
    {
        if (preg_match('/MSIE/i', $ua) && !preg_match('/Opera/i', $ua)) return 'MSIE';
        if (preg_match('/Firefox/i', $ua)) return 'Firefox';
        if (preg_match('/Chrome/i', $ua)) return 'Chrome';
        if (preg_match('/Safari/i', $ua)) return 'Safari';
        if (preg_match('/Opera/i', $ua)) return 'Opera';
        return 'Other';
    }

    protected function getOS($ua)
    {
        if (preg_match('/windows|win32/i', $ua)) return 'Windows';
        if (preg_match('/macintosh|mac os x/i', $ua)) return 'Mac OS';
        if (preg_match('/linux/i', $ua)) return 'Linux';
        if (preg_match('/iphone|ipad|ipod/i', $ua)) return 'iOS';
        if (preg_match('/android/i', $ua)) return 'Android';
        return 'Other';
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
