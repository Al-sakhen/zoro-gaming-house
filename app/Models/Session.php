<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Session extends Model
{
    protected $table = 'gaming_sessions';
    
    protected $fillable = [
        'room_id',
        'controller_count',
        'started_at',
        'ended_at',
        'is_active',
        'discount_amount',
        'discount_percentage',
        'final_total',
        'gaming_price_adjustment',
        'adjusted_gaming_price',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
        'is_active' => 'boolean',
        'controller_count' => 'integer',
        'discount_amount' => 'float',
        'discount_percentage' => 'float',
        'final_total' => 'float',
        'gaming_price_adjustment' => 'float',
        'adjusted_gaming_price' => 'float',
    ];

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function finalOrders(): HasMany
    {
        return $this->hasMany(FinalOrder::class);
    }

    // Helper method for the reports view
    public function getOrderAttribute()
    {
        // Return a pseudo-order object with the session's final total
        return (object) [
            'total_amount' => $this->final_total ?? $this->calculateGrandTotal()
        ];
    }

    public function getDurationInMinutes(): int
    {
        $endTime = $this->ended_at ?? now();
        return $this->started_at->diffInMinutes($endTime);
    }

    public function getDurationInHours(): float
    {
        $minutes = $this->getDurationInMinutes();
        return $minutes > 0 ? $minutes / 60 : 0; // Exact duration in decimal hours
    }

    public function getFormattedDuration(): string
    {
        $totalMinutes = $this->getDurationInMinutes();
        
        if ($totalMinutes < 60) {
            return $totalMinutes . 'm';
        }
        
        $hours = floor($totalMinutes / 60);
        $minutes = $totalMinutes % 60;
        
        if ($minutes == 0) {
            return $hours . 'h';
        }
        
        return $hours . 'h ' . $minutes . 'm';
    }

    public function getFormattedDurationForReports(): string
    {
        $totalMinutes = $this->getDurationInMinutes();
        
        if ($totalMinutes < 60) {
            return number_format($totalMinutes / 60, 1) . 'h';
        }
        
        return number_format($totalMinutes / 60, 1) . 'h (' . $this->getFormattedDuration() . ')';
    }

    public function getDurationHHMMSS(): string
    {
        if (!$this->started_at) return '00:00:00';

        $endTime = $this->ended_at ?? now();
        $duration = $this->started_at->diff($endTime);

        return sprintf('%02d:%02d:%02d', $duration->h, $duration->i, $duration->s);
    }

    // Static helper method to format decimal hours into readable format
    public static function formatDecimalHours(float $decimalHours): string
    {
        if ($decimalHours < 1) {
            $minutes = round($decimalHours * 60);
            return $minutes . 'm';
        }
        
        $hours = floor($decimalHours);
        $minutes = round(($decimalHours - $hours) * 60);
        
        if ($minutes == 0) {
            return $hours . 'h';
        }
        
        return $hours . 'h ' . $minutes . 'm';
    }

    public function calculateGamingPrice(): float
    {
        $durationInHours = $this->getDurationInHours();
        
        // Get price based on room type and controller count
        $pricePerHour = $this->room->type === 'tables' ? 0 : $this->getPricePerHour();
        
        return number_format($durationInHours * $pricePerHour, 2, '.', '');
    }

    public function getPricePerHour(): float
    {
        if ($this->room->type === 'playstation' && $this->controller_count) {
            return $this->room->getPriceForControllers($this->controller_count);
        }
        
        return $this->room->price_per_hour;
    }

    public function calculateCafeteriaTotal(): float
    {
        // For active sessions, use temporary orders
        // For ended sessions, use final orders (original prices, no item-level discounts)
        if ($this->is_active) {
            return $this->orders->sum('total_price');
        } else {
            return $this->finalOrders->sum('total_price');
        }
    }

    public function calculateOriginalCafeteriaTotal(): float
    {
        // Always returns the original total before any discounts
        return $this->calculateCafeteriaTotal();
    }

    public function calculateOriginalGrandTotal(): float
    {
        // Total before any session-level discount
        return $this->calculateGamingPrice() + $this->calculateCafeteriaTotal();
    }

    public function calculateGrandTotal(): float
    {
        // If session has discount applied, return the final_total
        // Otherwise return the original total
        if (!$this->is_active && $this->final_total !== null) {
            return $this->final_total;
        }
        
        return $this->calculateOriginalGrandTotal();
    }

    public function hasDiscount(): bool
    {
        return !$this->is_active && $this->discount_amount > 0;
    }

    public function hasGamingAdjustment(): bool
    {
        return $this->gaming_price_adjustment && $this->gaming_price_adjustment != 0;
    }

    public function getFinalGamingPrice(): float
    {
        return $this->adjusted_gaming_price ?? $this->calculateGamingPrice();
    }

    public function getRevenuePerHour(): float
    {
        $durationHours = $this->getDurationInHours();
        if ($durationHours <= 0 || $this->is_active) {
            return 0;
        }
        
        $total = $this->final_total ?? $this->calculateGrandTotal();
        return $total / $durationHours;
    }
}
