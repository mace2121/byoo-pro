<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LinkPreview extends Model
{
    protected $fillable = [
        'url_hash',
        'url',
        'title',
        'description',
        'favicon',
        'image',
        'last_fetched_at',
    ];

    protected function casts(): array
    {
        return [
            'last_fetched_at' => 'datetime',
        ];
    }
}
