<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'user_id',
        'is_premium',
        'is_active',
        'is_approved',
        'preview_image',
        'config_json',
    ];

    protected $casts = [
        'config_json' => 'array',
        'is_premium' => 'boolean',
        'is_active' => 'boolean',
        'is_approved' => 'boolean',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
