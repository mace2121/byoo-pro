<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
