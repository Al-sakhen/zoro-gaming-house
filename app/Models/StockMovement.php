<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockMovement extends Model
{
    protected $fillable = [
        'cafeteria_item_id',
        'session_id',
        'movement_type',
        'quantity_change',
        'quantity_before',
        'quantity_after',
        'source',
        'note',
    ];

    protected $casts = [
        'cafeteria_item_id' => 'integer',
        'session_id' => 'integer',
        'quantity_change' => 'integer',
        'quantity_before' => 'integer',
        'quantity_after' => 'integer',
    ];

    public function cafeteriaItem(): BelongsTo
    {
        return $this->belongsTo(CafeteriaItem::class);
    }

    public function session(): BelongsTo
    {
        return $this->belongsTo(Session::class);
    }
}
