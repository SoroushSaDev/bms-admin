<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Register;

class Command extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    const Types = [
        'Text' => 'Text',
        'Switch' => 'Switch',
        'SetPoint' => 'Set Point',
    ];

    public function Register()
    {
        return $this->belongsTo(Register::class, 'register_id', 'id');
    }

    public function GetType()
    {
        return self::Types[$this->type];
    }    
}
