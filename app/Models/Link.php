<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'url',
        'icon',
        'order',
        'is_active',
        'clicks',
        'starts_at',
        'expires_at',
        'password',
        'type',
    ];

    public function getPlatformAttribute()
    {
        $url = strtolower($this->url);
        
        if (str_contains($url, 'instagram.com')) return 'instagram';
        if (str_contains($url, 'twitter.com') || str_contains($url, 'x.com')) return 'twitter';
        if (str_contains($url, 'facebook.com') || str_contains($url, 'fb.com')) return 'facebook';
        if (str_contains($url, 'linkedin.com')) return 'linkedin';
        if (str_contains($url, 'youtube.com') || str_contains($url, 'youtu.be')) return 'youtube';
        if (str_contains($url, 'tiktok.com')) return 'tiktok';
        if (str_contains($url, 'whatsapp.com') || str_contains($url, 'wa.me')) return 'whatsapp';
        if (str_contains($url, 'github.com')) return 'github';
        if (str_contains($url, 't.me') || str_contains($url, 'telegram.org')) return 'telegram';
        
        return 'link';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function clickLogs()
    {
        return $this->hasMany(ClickLog::class);
    }
}
