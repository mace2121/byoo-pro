<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ViewLog extends Model
{
    protected $fillable = [
        'profile_id',
        'ip',
        'device',
        'country',
        'browser',
        'os',
        'referer',
    ];

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }
}
