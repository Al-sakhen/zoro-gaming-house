<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    protected $table = 'gaming_orders';
    
    protected $fillable = [
        'session_id',
        'cafeteria_item_id',
        'units_count',
        'price_per_unit',
        'total_price',
    ];

    protected $casts = [
        'units_count' => 'integer',
        'price_per_unit' => 'float',
        'total_price' => 'float',
    ];

    public function session(): BelongsTo
    {
        return $this->belongsTo(Session::class);
    }

    public function cafeteriaItem(): BelongsTo
    {
        return $this->belongsTo(CafeteriaItem::class);
    }

    public function getFormattedTotalAttribute(): string
    {
        return number_format($this->total_price, 2) . ' JD';
    }
}
