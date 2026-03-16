<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Block extends Model
{
    protected $fillable = [
        'user_id',
        'source_link_id',
        'type',
        'title',
        'description',
        'image',
        'url',
        'button_type',
        'button_link',
        'position',
        'is_active',
        'data',
    ];

    protected function casts(): array
    {
        return [
            'data' => 'array',
            'is_active' => 'boolean',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sourceLink()
    {
        return $this->belongsTo(Link::class, 'source_link_id');
    }

    protected function imageUrl(): Attribute
    {
        return Attribute::get(function () {
            if (! $this->image) {
                return null;
            }

            if (filter_var($this->image, FILTER_VALIDATE_URL)) {
                return $this->image;
            }

            return Storage::disk('public')->url($this->image);
        });
    }
}
