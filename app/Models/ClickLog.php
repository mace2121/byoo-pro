<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClickLog extends Model
{
    protected $fillable = [
        'link_id',
        'ip',
        'device',
        'country',
        'browser',
        'os',
        'referer',
    ];

    public function link()
    {
        return $this->belongsTo(Link::class);
    }
}
