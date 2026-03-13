<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Profile extends Model
{
    /** @use HasFactory<\Database\Factories\ProfileFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'username',
        'avatar',
        'bio',
        'theme',
        'theme_type',
        'bg_type',
        'bg_color',
        'bg_gradient',
        'bg_image',
        'bg_blur',
        'bg_overlay',
        'text_color',
        'button_color',
        'button_text_color',
        'button_style',
        'button_shadow',
        'font_family',
        'custom_css',
        'meta_title',
        'meta_description',
        'custom_domain',
        'custom_domain_verified',
        'is_active',
        'views',
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

            return "https://ui-avatars.com/api/?name=" . urlencode($this->user->name ?? $this->username) . "&size=512&background=random&color=fff";
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

    /**
     * Sanitize custom CSS to prevent XSS.
     */
    protected function customCss(): Attribute
    {
        return Attribute::set(fn ($value) => strip_tags($value));
    }
}
