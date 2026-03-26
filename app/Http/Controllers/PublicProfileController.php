<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Models\Profile;
use App\Models\User;
use App\Models\Block;
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
        $user = User::where('username', $username)->firstOrFail();
        return $this->renderProfile($user);
    }

    public function showByCustomDomain(Request $request)
    {
        $profile = $request->attributes->get('custom_domain_profile');
        if (!$profile) abort(404);
        return $this->renderProfile($profile->user);
    }

    protected function renderProfile(User $user)
    {
        $data = $this->profileService->getProfileData($user);
        if (!$data) abort(404);

        $profile = $data['profile'];
        $links = $data['links'];
        $blocks = $data['blocks'];

        $request = request();
        $ua = $request->userAgent();
        $parsedUA = $this->profileService->parseUserAgent($ua);
        $ip = $request->ip();
        $location = $this->profileService->getIPLocation($ip);
        
        $this->profileService->logView($profile, [
            'ip' => $ip,
            'device' => substr($ua, 0, 255),
            'country' => $location['country'] ?? $request->header('CF-IPCountry'),
            'city' => $location['city'] ?? null,
            'browser' => $parsedUA['browser'],
            'os' => $parsedUA['os'],
            'referer' => $request->headers->get('referer'),
        ]);

        return view('public.profile', compact('user', 'profile', 'links', 'blocks'));
    }

    public function redirect(Link $link, Request $request)
    {
        $now = now();
        if (!$link->is_active || 
            ($link->starts_at && $link->starts_at > $now) || 
            ($link->expires_at && $link->expires_at < $now) ||
            !$link->user?->profile?->is_active) {
            abort(404);
        }

        if ($link->password) {
            $sessionKey = 'link_verified_' . $link->id;
            if (!session()->has($sessionKey)) {
                return view('public.password-prompt', compact('link'));
            }
        }

        $link->increment('clicks');
        $ip = $request->ip();
        $location = $this->profileService->getIPLocation($ip);
        $ua = $request->userAgent();
        $parsedUA = $this->profileService->parseUserAgent($ua);

        $link->clickLogs()->create([
            'ip' => $ip,
            'device' => substr($ua, 0, 255),
            'country' => $location['country'] ?? $request->header('CF-IPCountry'),
            'city' => $location['city'] ?? null,
            'browser' => $parsedUA['browser'],
            'os' => $parsedUA['os'],
            'referer' => $request->headers->get('referer'),
        ]);

        return redirect()->away($link->url);
    }

    public function blockRedirect(Block $block, Request $request)
    {
        $now = now();
        if (!$block->is_active || 
            ($block->starts_at && $block->starts_at > $now) || 
            ($block->expires_at && $block->expires_at < $now) ||
            !$block->user?->profile?->is_active) {
            abort(404);
        }

        $block->increment('clicks');
        
        // Also increment source link clicks if exists
        if ($block->sourceLink) {
            $block->sourceLink->increment('clicks');
        }

        $ip = $request->ip();
        $location = $this->profileService->getIPLocation($ip);
        $ua = $request->userAgent();
        $parsedUA = $this->profileService->parseUserAgent($ua);

        $block->clickLogs()->create([
            'link_id' => $block->source_link_id,
            'ip' => $ip,
            'device' => substr($ua, 0, 255),
            'country' => $location['country'] ?? $request->header('CF-IPCountry'),
            'city' => $location['city'] ?? null,
            'browser' => $parsedUA['browser'],
            'os' => $parsedUA['os'],
            'referer' => $request->headers->get('referer'),
        ]);

        $url = $block->button_link ?: $block->url ?: '#';

        if ($block->type === 'product' && $block->button_type === 'whatsapp') {
            $waPhone = preg_replace('/\D/', '', $url);
            $message = $block->data['whatsapp_message'] ?? '';
            $url = "https://wa.me/{$waPhone}?text=" . rawurlencode($message);
        }

        return redirect()->away($url);
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
