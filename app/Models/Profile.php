<?php

namespace App\Models;

use Database\Factories\ProfileFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Profile extends Model
{
    /** @use HasFactory<ProfileFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'username',
        'avatar',
        'bio',
        'bg_image',
        'meta_title',
        'meta_description',
        'custom_domain',
        'custom_domain_verified',
        'design_settings',
        'is_active',
        'views',
    ];

    protected $casts = [
        'design_settings' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * Get the profile's avatar URL with fallback.
     */
    protected function avatarUrl(): Attribute
    {
        return Attribute::get(function () {
            if ($this->avatar) {
                // If it's already a URL, return it
                if (filter_var($this->avatar, FILTER_VALIDATE_URL)) {
                    return $this->avatar;
                }

                // Ensure the path is correct for Storage
                return Storage::disk('public')->url($this->avatar);
            }

            return 'https://ui-avatars.com/api/?name='.urlencode($this->user->name ?? $this->username).'&size=512&background=random&color=fff';
        });
    }

    /**
     * Get the profile's background image URL.
     */
    protected function bgImageUrl(): Attribute
    {
        return Attribute::get(function () {
            if ($this->bg_image) {
                if (filter_var($this->bg_image, FILTER_VALIDATE_URL)) {
                    return $this->bg_image;
                }

                return Storage::disk('public')->url($this->bg_image);
            }

            return null;
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function viewLogs()
    {
        return $this->hasMany(ViewLog::class);
    }
}
