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
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function clickLogs()
    {
        return $this->hasMany(ClickLog::class);
    }
}
