<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pattern extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    const Types = [
        'Json',
        'Array',
        'Custom',
    ];

    public function Device()
    {
        return $this->belongsTo(Device::class, 'device_id', 'id');
    }

    public function User()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
