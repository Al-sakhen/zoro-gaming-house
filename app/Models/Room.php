<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Room extends Model
{
    protected $fillable = [
        'name',
        'type',
        'price_per_hour',
        'price_per_hour_2_controllers',
        'price_per_hour_4_controllers',
        'is_vip',
        'status',
    ];

    protected $attributes = [
        'type' => 'pc',
        'price_per_hour' => 0,
        'price_per_hour_2_controllers' => null,
        'price_per_hour_4_controllers' => null,
        'is_vip' => false,
        'status' => 'available',
    ];

    protected $casts = [
        'price_per_hour' => 'decimal:2',
        'is_vip' => 'boolean',
    ];

    // Custom accessors to handle nullable decimal values
    public function getPricePerHour2ControllersAttribute($value)
    {
        return $value !== null ? (float) $value : null;
    }

    public function getPricePerHour4ControllersAttribute($value)
    {
        return $value !== null ? (float) $value : null;
    }

    public function sessions(): HasMany
    {
        return $this->hasMany(Session::class);
    }

    public function activeSession()
    {
        return $this->sessions()->where('is_active', true)->first();
    }

    public function isOccupied(): bool
    {
        return $this->activeSession() !== null;
    }

    public function getPriceForControllers(int $controllerCount): float
    {
        if ($this->type !== 'playstation') {
            return $this->price_per_hour;
        }

        return match($controllerCount) {
            2 => $this->price_per_hour_2_controllers ?? $this->price_per_hour,
            4 => $this->price_per_hour_4_controllers ?? $this->price_per_hour,
            default => $this->price_per_hour,
        };
    }

    public function getDefaultPrice(): float
    {
        return match($this->type) {
            'tables' => 0,
            'playstation' => $this->price_per_hour_2_controllers ?? $this->price_per_hour,
            default => $this->price_per_hour,
        };
    }

    public function isPlaystation(): bool
    {
        return $this->type === 'playstation';
    }

    public function isPc(): bool
    {
        return $this->type === 'pc';
    }

    public function isTable(): bool
    {
        return $this->type === 'tables';
    }
}
