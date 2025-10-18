<?php

namespace App\Livewire;

use App\Models\Session;
use App\Models\Order;
use App\Models\FinalOrder;
use Livewire\Component;

class SessionSummary extends Component
{
    public Session $session;
    public $tempOrders;
    public $discountAmount = 0;
    public $finalPriceAfterDiscount = 0;
    public $discountPercentage = 0;
    public $adjustedGamingPrice = 0;
    public $gamingPriceAdjustment = 0;
    
    // Duration adjustment properties (for price calculation only)
    public $adjustedHours = 0;
    public $adjustedMinutes = 0;
    public $originalGamingPrice = 0;
    
    public function mount(Session $session)
    {
        $this->session = $session;
        $this->tempOrders = Order::where('session_id', $session->id)
            ->with('cafeteriaItem')
            ->get();
        
        // Initialize final price with proper rounding
        $this->finalPriceAfterDiscount = round($this->session->calculateGrandTotal(), 2);
        
        // Initialize adjusted gaming price with original gaming price
        $this->adjustedGamingPrice = $this->session->calculateGamingPrice();
        $this->originalGamingPrice = $this->session->calculateGamingPrice();
        $this->gamingPriceAdjustment = 0;
        
        // Initialize duration fields with actual session duration
        $durationMinutes = $this->session->getDurationInMinutes();
        $this->adjustedHours = floor($durationMinutes / 60);
        $this->adjustedMinutes = $durationMinutes % 60;
    }

    public function updatedDiscountAmount()
    {
        // Use adjusted gaming price instead of original
        $cafeteriaTotal = $this->session->calculateCafeteriaTotal();
        $currentGrandTotal = $this->adjustedGamingPrice + $cafeteriaTotal;
        
        if ($this->discountAmount >= 0 && $this->discountAmount <= $currentGrandTotal) {
            $this->finalPriceAfterDiscount = round($currentGrandTotal - $this->discountAmount, 2);
            $this->discountPercentage = $currentGrandTotal > 0 ? round(($this->discountAmount / $currentGrandTotal) * 100, 2) : 0;
            
            // Reset gaming price adjustment since we're using duration-adjusted price
            $this->gamingPriceAdjustment = 0;
        } else {
            $this->discountAmount = 0;
            $this->finalPriceAfterDiscount = round($currentGrandTotal, 2);
            $this->discountPercentage = 0;
            $this->gamingPriceAdjustment = 0;
        }
    }

    public function updatedFinalPriceAfterDiscount()
    {
        // Use adjusted gaming price and cafeteria total
        $cafeteriaTotal = $this->session->calculateCafeteriaTotal();
        $currentGrandTotal = $this->adjustedGamingPrice + $cafeteriaTotal;
        
        if ($this->finalPriceAfterDiscount >= 0) {
            $difference = $this->finalPriceAfterDiscount - $currentGrandTotal;
            
            if ($difference < 0) {
                // Price is less than current total (discount scenario)
                $this->discountAmount = round(abs($difference), 2);
                $this->discountPercentage = $currentGrandTotal > 0 ? round(($this->discountAmount / $currentGrandTotal) * 100, 2) : 0;
                $this->gamingPriceAdjustment = 0;
            } elseif ($difference > 0) {
                // Price is greater than current total (increase scenario)
                // Add the increase to gaming price, keep cafeteria price unchanged
                $this->discountAmount = 0;
                $this->discountPercentage = 0;
                $this->gamingPriceAdjustment = round($difference, 2);
                $this->adjustedGamingPrice = round($this->adjustedGamingPrice + $this->gamingPriceAdjustment, 2);
            } else {
                // Price equals current total (no change)
                $this->discountAmount = 0;
                $this->discountPercentage = 0;
                $this->gamingPriceAdjustment = 0;
            }
        } else {
            // Invalid input, reset to current total
            $this->finalPriceAfterDiscount = round($currentGrandTotal, 2);
            $this->discountAmount = 0;
            $this->discountPercentage = 0;
            $this->gamingPriceAdjustment = 0;
        }
    }

    public function updatedAdjustedHours()
    {
        $this->recalculateGamingPrice();
    }

    public function updatedAdjustedMinutes()
    {
        $this->recalculateGamingPrice();
    }

    private function recalculateGamingPrice()
    {
        // Ensure valid values
        $this->adjustedHours = max(0, (int)$this->adjustedHours);
        $this->adjustedMinutes = max(0, min(59, (int)$this->adjustedMinutes));
        
        // Calculate total adjusted minutes
        $totalAdjustedMinutes = ($this->adjustedHours * 60) + $this->adjustedMinutes;
        
        // Calculate gaming price based on adjusted duration
        // Assuming the room has an hourly rate
        $hourlyRate = $this->session->room->price_per_hour ?? 3.00; // Default rate if not set
        $adjustedDurationHours = $totalAdjustedMinutes / 60;
        $this->adjustedGamingPrice = round($adjustedDurationHours * $hourlyRate, 2);
        
        // Recalculate final price WHILE PRESERVING THE DISCOUNT
        $cafeteriaTotal = $this->session->calculateCafeteriaTotal();
        $newGrandTotal = $this->adjustedGamingPrice + $cafeteriaTotal;
        
        // Apply the existing discount to the new total
        $this->finalPriceAfterDiscount = round($newGrandTotal - $this->discountAmount, 2);
        
        // Recalculate discount percentage based on new total
        if ($newGrandTotal > 0) {
            $this->discountPercentage = $this->discountAmount > 0 ? round(($this->discountAmount / $newGrandTotal) * 100, 2) : 0;
        }
    }

    public function getFormattedDuration()
    {
        return sprintf('%d:%02d', $this->adjustedHours, $this->adjustedMinutes);
    }

    public function resetMinutes()
    {
        $this->adjustedMinutes = 0;
        $this->recalculateGamingPrice();
    }

    public function confirmEndSession()
    {
        // Transfer temporary orders to final orders WITHOUT discount information
        // (Store original prices only, discount will be applied at session level)
        foreach ($this->tempOrders as $tempOrder) {
            FinalOrder::create([
                'session_id' => $tempOrder->session_id,
                'cafeteria_item_id' => $tempOrder->cafeteria_item_id,
                'units_count' => $tempOrder->units_count,
                'price_per_unit' => $tempOrder->price_per_unit,
                'total_price' => $tempOrder->total_price,
            ]);
        }

        // Delete temporary orders
        Order::where('session_id', $this->session->id)->delete();

        // Apply discount/adjustment at session level and finalize the session
        $this->session->update([
            'discount_amount' => $this->discountAmount,
            'discount_percentage' => $this->discountPercentage,
            'gaming_price_adjustment' => $this->gamingPriceAdjustment,
            'adjusted_gaming_price' => $this->adjustedGamingPrice,
            'final_total' => $this->finalPriceAfterDiscount,
            'is_active' => false,
        ]);

        // Update room status
        $this->session->room->update(['status' => 'available']);

        session()->flash('message', 'Session ended successfully with ' . $this->tempOrders->count() . ' orders finalized!');
        
        // Notify JavaScript that session was properly ended
        $this->dispatch('sessionConfirmed');
        
        // Close the window
        $this->dispatch('closeSessionWindow');
    }

    public function cancelEndSession()
    {
        // Reset the ended_at to null to resume billing
        $this->session->update([
            'ended_at' => null,
        ]);

        session()->flash('message', 'Session ending cancelled. Session resumed.');
        
        $this->dispatch('closeSessionWindow');
    }

    public function handlePopupClosure()
    {
        // This method will be called when the popup is closed by browser X button
        // Reset the ended_at to null to resume billing (same as cancel)
        $this->session->update([
            'ended_at' => null,
        ]);
    }

    public function render()
    {
        return view('livewire.session-summary');
    }
}
