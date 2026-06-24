<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CafeteriaItem extends Model
{
    protected $fillable = [
        'name',
        'barcode',
        'price_per_item',
        'cost_price',
        'quantity',
        'status',
    ];

    protected $casts = [
        'price_per_item' => 'float',
        'cost_price' => 'float',
        'quantity' => 'integer',
    ];

    public function gamingOrders(): HasMany
    {
        return $this->hasMany(Order::class, 'cafeteria_item_id');
    }

    public function stockMovements(): HasMany
    {
        return $this->hasMany(StockMovement::class, 'cafeteria_item_id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function getFormattedPriceAttribute(): string
    {
        return number_format($this->price_per_item, 2) . ' JD';
    }
}
