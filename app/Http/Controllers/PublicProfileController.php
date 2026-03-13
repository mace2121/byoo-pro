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

        // Kullanıcının SADECE aktif linklerini, order siralamasına gore getir
        $links = $user->links()->where('is_active', true)->orderBy('order')->get();

        return view('public.profile', compact('user', 'profile', 'links'));
    }

    public function redirect(Link $link, Request $request)
    {
        // Link aktif değilse veya kullanıcının profili aktif değilse engelle
        if (!$link->is_active || !$link->user->profile->is_active) {
            abort(404);
        }

        // Tıklama sayısını 1 arttır
        $link->increment('clicks');

        // Extract IP & Device, Country if available
        $ip = $request->ip();
        $device = substr($request->userAgent(), 0, 255); // limit length just in case
        $country = $request->header('CF-IPCountry'); // Cloudflare country header

        // ClickLog oluştur
        $link->clickLogs()->create([
            'ip' => $ip,
            'device' => $device,
            'country' => $country,
        ]);

        return redirect()->away($link->url);
    }
}
