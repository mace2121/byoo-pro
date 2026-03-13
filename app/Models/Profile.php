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
                return Storage::disk('public')->url($this->avatar);
            }

            return "https://ui-avatars.com/api/?name=" . urlencode($this->user->name) . "&size=512&background=random";
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
