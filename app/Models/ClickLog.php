<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClickLog extends Model
{
    protected $fillable = [
        'link_id',
        'block_id',
        'ip',
        'device',
        'country',
        'city',
        'browser',
        'os',
        'referer',
    ];

    public function link()
    {
        return $this->belongsTo(Link::class);
    }

    public function block()
    {
        return $this->belongsTo(Block::class);
    }
}
