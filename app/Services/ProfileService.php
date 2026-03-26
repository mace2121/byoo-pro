<?php

namespace App\Services;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Support\Facades\Cache;

class ProfileService
{
    public function __construct(protected BlockService $blockService)
    {
    }

    /**
     * Get location data from IP address.
     */
    public function getIPLocation($ip)
    {
        if ($ip === '127.0.0.1' || !$ip) return null;

        return Cache::remember("ip_loc_{$ip}", now()->addDays(7), function () use ($ip) {
            try {
                $response = file_get_contents("http://ip-api.com/json/{$ip}?fields=status,country,city,countryCode", false, stream_context_create([
                    'http' => ['timeout' => 2]
                ]));
                
                if ($response) {
                    $data = json_decode($response, true);
                    if (($data['status'] ?? '') === 'success') {
                        return [
                            'country' => $data['country'] ?? null,
                            'city' => $data['city'] ?? null,
                            'countryCode' => $data['countryCode'] ?? null,
                        ];
                    }
                }
            } catch (\Exception $e) {
                // Silently fail to avoid blocking profile load
            }
            return null;
        });
    }

    /**
     * Get a user's profile and active links with caching.
     */
    public function getProfileData(User $user)
    {
        $cacheKey = "profile_data_v2_{$user->id}";

        return Cache::remember($cacheKey, now()->addHours(24), function () use ($user) {
            $profile = $user->profile;
            
            if (!$profile || !$profile->is_active) {
                return null;
            }

            $now = now();
            $links = $user->links()
                ->where('is_active', true)
                ->where(function ($query) use ($now) {
                    $query->whereNull('starts_at')
                        ->orWhere('starts_at', '<=', $now);
                })
                ->where(function ($query) use ($now) {
                    $query->whereNull('expires_at')
                        ->orWhere('expires_at', '>=', $now);
                })
                ->orderBy('order')
                ->get();

            return [
                'profile' => $profile,
                'links' => $links,
                'blocks' => $this->blockService->getRenderableBlocks($user),
            ];
        });
    }

    /**
     * Clear the cache for a specific user's profile.
     */
    public function clearProfileCache(User $user)
    {
        Cache::forget("profile_data_v2_{$user->id}");
    }

    /**
     * Log a profile view with metadata.
     */
    public function logView(Profile $profile, array $metadata)
    {
        $profile->increment('views');
        
        return $profile->viewLogs()->create($metadata);
    }

    /**
     * Parse User Agent for browser and OS info.
     * (Moved from Controller to Service for reuse)
     */
    public function parseUserAgent($ua)
    {
        return [
            'browser' => $this->getBrowser($ua),
            'os' => $this->getOS($ua),
        ];
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
}
