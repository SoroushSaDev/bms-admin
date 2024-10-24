<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Http;

class Device extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public static function boot(): void
    {
        parent::boot();
        static::creating(function (Device $device) {
            $device->user_id = auth()->check() ? auth()->id() : null;
        });
        static::updating(function (Device $device) {
            $device->user_id = auth()->check() ? auth()->id() : null;
        });
    }

    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function Registers(): HasMany
    {
        return $this->hasMany(Register::class, 'device_id', 'id');
    }

    public function Patterns()
    {
        return $this->hasMany(Pattern::class, 'device_id', 'id');
    }

    public function Children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id', 'id');
    }

    public function Parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id', 'id');
    }

    public function Translate(): void
    {
        TranslateAll($this, ['name', 'type', 'brand', 'model', 'description']);
        $this->Registers->map(function ($register) {
            $register->Translate();
        });
    }
}
