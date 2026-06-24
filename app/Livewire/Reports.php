<?php

namespace App\Livewire;

use App\Models\Order;
use App\Models\Room;
use App\Models\Session;
use App\Models\FinalOrder;
use Carbon\Carbon;
use Livewire\Component;

class Reports extends Component
{
    public $selectedPeriod = 'custom';
    public $startDate;
    public $endDate;
    public $startTime = '00:00';
    public $endTime = '23:59';
    public $reportGenerated = false;
    
    // Report Data
    public $totalRevenue = 0;
    public $totalPlayingRevenue = 0;
    public $totalSessions = 0;
    public $totalGamingHours = 0;
    public $totalCafeteriaRevenue = 0;
    public $totalCafeteriaCost = 0;
    public $totalCafeteriaActualRevenue = 0;
    public $totalActualRevenue = 0;
    public $averageSessionDuration = 0;
    public $averageRevenuePerHour = 0;
    
    public $roomStats = [];
    public $cafeteriaStats = [];
    public $dailyStats = [];
    public $hourlyStats = [];
    public $peakHours = [];
    public $revenueByDay = [];
    public $roomUtilization = [];
    
    // New enhanced features
    public $dayOfWeekStats = [];
    public $last30DaysTrend = [];
    public $revenueGoals = [];
    public $executiveSummary = [];

    public function mount()
    {
        // Set default date range to last 7 days
        $this->endDate = now()->format('Y-m-d');
        $this->startDate = now()->subDays(7)->format('Y-m-d');
        $this->setDateRange();
    }

    public function updatedSelectedPeriod()
    {
        $this->setDateRange();
    }

    private function setDateRange()
    {
        switch ($this->selectedPeriod) {
            case 'today':
                $this->startDate = now()->format('Y-m-d');
                $this->endDate = now()->format('Y-m-d');
                break;
            case 'yesterday':
                $this->startDate = now()->subDay()->format('Y-m-d');
                $this->endDate = now()->subDay()->format('Y-m-d');
                break;
            case 'week':
                $this->startDate = now()->startOfWeek()->format('Y-m-d');
                $this->endDate = now()->endOfWeek()->format('Y-m-d');
                break;
            case 'month':
                $this->startDate = now()->startOfMonth()->format('Y-m-d');
                $this->endDate = now()->endOfMonth()->format('Y-m-d');
                break;
            case 'last_month':
                $this->startDate = now()->subMonth()->startOfMonth()->format('Y-m-d');
                $this->endDate = now()->subMonth()->endOfMonth()->format('Y-m-d');
                break;
            case 'custom':
                // Keep current dates
                break;
        }
    }

    public function getTotalRevenue()
    {
        return Order::whereHas('session', function($query) {
                $query->whereBetween('created_at', [$this->startDate, $this->endDate]);
            })
            ->sum('total_amount');
    }

    public function getTotalSessions()
    {
        return Session::whereBetween('created_at', [$this->startDate, $this->endDate])
            ->where('is_active', false)
            ->count();
    }

    public function getAverageSessionDuration()
    {
        $sessions = Session::whereBetween('created_at', [$this->startDate, $this->endDate])
            ->where('is_active', false)
            ->whereNotNull('ended_at')
            ->get();

        if ($sessions->isEmpty()) {
            return 0;
        }

        $totalMinutes = $sessions->sum(function($session) {
            return $session->getDurationInMinutes();
        });

        return round($totalMinutes / $sessions->count());
    }

    public function getRoomUtilization()
    {
        $rooms = Room::withCount(['sessions' => function($query) {
            $query->whereBetween('created_at', [$this->startDate, $this->endDate])
                  ->where('is_active', false);
        }])->get();

        return $rooms->mapWithKeys(function($room) {
            return [$room->name => $room->sessions_count];
        });
    }

    public function getRevenueByDay()
    {
        $days = [];
        $current = $this->startDate->copy();
        
        while ($current <= $this->endDate) {
            $dayRevenue = Order::whereHas('session', function($query) use ($current) {
                    $query->whereDate('created_at', $current->toDateString());
                })
                ->sum('total_amount');
                
            $days[$current->format('M j')] = $dayRevenue;
            $current->addDay();
        }

        return $days;
    }

    public function generateReport()
    {
        $this->validate([
            'startDate' => 'required|date',
            'endDate' => 'required|date|after_or_equal:startDate',
            'startTime' => 'required',
            'endTime' => 'required',
        ]);
        
        $this->calculateBasicStats();
        $this->calculateRoomStats();
        $this->calculateCafeteriaStats();
        $this->calculateDailyStats();
        $this->calculateHourlyStats();
        $this->calculatePeakHours();
        
        // New enhanced features
        $this->calculateDayOfWeekStats();
        $this->calculateLast30DaysTrend();
        $this->calculateRevenueGoals();
        $this->calculateExecutiveSummary();
        
        $this->reportGenerated = true;
    }
    
    private function getSessionsQuery()
    {
        $fromDateTime = Carbon::parse($this->startDate . ' ' . $this->startTime);
        $toDateTime = Carbon::parse($this->endDate . ' ' . $this->endTime);
        
        return Session::whereBetween('created_at', [$fromDateTime, $toDateTime])
            ->with(['room', 'orders.cafeteriaItem', 'finalOrders.cafeteriaItem']);
    }
    
    private function calculateBasicStats()
    {
        $sessions = $this->getSessionsQuery()->get();
        
        $this->totalSessions = $sessions->count();
        $this->totalRevenue = $sessions->sum(function($session) {
            return $session->final_total ?? $session->calculateGrandTotal();
        });
        $this->totalPlayingRevenue = $sessions->sum(function($session) {
            return $session->getFinalGamingPrice();
        });
        $this->totalGamingHours = $sessions->sum(function($session) {
            return $session->getDurationInHours();
        });

        // Will be recalculated accurately from order lines in calculateCafeteriaStats()
        $this->totalCafeteriaRevenue = 0;
        $this->totalCafeteriaCost = 0;
        $this->totalCafeteriaActualRevenue = 0;
        $this->totalActualRevenue = $this->totalRevenue;
        
        $this->averageSessionDuration = $this->totalSessions > 0 
            ? $this->totalGamingHours / $this->totalSessions 
            : 0;
            
        $this->averageRevenuePerHour = $this->totalGamingHours > 0 
            ? $this->totalRevenue / $this->totalGamingHours 
            : 0;
            
        // Calculate revenue by day
        $this->calculateRevenueByDay();
        
        // Calculate room utilization
        $this->calculateRoomUtilization();
    }
    
    private function calculateRoomStats()
    {
        $fromDateTime = Carbon::parse($this->startDate . ' ' . $this->startTime);
        $toDateTime = Carbon::parse($this->endDate . ' ' . $this->endTime);
        
        // Get room statistics using collection methods to avoid SQL issues
        $sessions = Session::with('room')
            ->whereBetween('created_at', [$fromDateTime, $toDateTime])
            ->get();
            
        $this->roomStats = $sessions->groupBy('room_id')->map(function($roomSessions, $roomId) {
            $room = $roomSessions->first()->room;
            $sessionCount = $roomSessions->count();
            $totalHours = $roomSessions->sum(function($session) {
                return $session->getDurationInHours();
            });
            $totalRevenue = $roomSessions->sum(function($session) {
                return $session->final_total ?? $session->calculateGrandTotal();
            });
            
            // Calculate original totals and adjustments
            $originalTotal = $roomSessions->sum(function($session) {
                return $session->calculateOriginalGrandTotal();
            });
            
            $totalDiscounts = $roomSessions->sum(function($session) {
                return $session->discount_amount ?? 0;
            });
            
            $totalAdjustments = $roomSessions->sum(function($session) {
                return $session->gaming_price_adjustment ?? 0;
            });
            
            return (object) [
                'room_id' => $roomId,
                'room' => $room,
                'session_count' => $sessionCount,
                'total_hours' => $totalHours,
                'total_revenue' => $totalRevenue,
                'original_total' => $originalTotal,
                'total_discounts' => $totalDiscounts,
                'total_adjustments' => $totalAdjustments,
                'avg_revenue' => $sessionCount > 0 ? $totalRevenue / $sessionCount : 0,
                'avg_revenue_per_hour' => $totalHours > 0 ? $totalRevenue / $totalHours : 0,
                'utilization_percentage' => $this->calculateUtilization($totalHours),
            ];
        })->sortByDesc('total_hours')->values();
    }
    
    private function calculateCafeteriaStats()
    {
        $fromDateTime = Carbon::parse($this->startDate . ' ' . $this->startTime);
        $toDateTime = Carbon::parse($this->endDate . ' ' . $this->endTime);

        // Split sessions to prevent double counting between temporary and finalized orders.
        $activeSessionIds = Session::whereBetween('created_at', [$fromDateTime, $toDateTime])
            ->where('is_active', true)
            ->pluck('id');
        $endedSessionIds = Session::whereBetween('created_at', [$fromDateTime, $toDateTime])
            ->where('is_active', false)
            ->pluck('id');
        
        // Combine stats from both Order and FinalOrder tables
        $combinedStats = collect();
        
        // Get active orders stats
        $activeOrders = Order::select('cafeteria_item_id')
            ->selectRaw('SUM(units_count) as total_quantity')
            ->selectRaw('SUM(total_price) as total_revenue')
            ->selectRaw('COUNT(*) as order_count')
            ->with('cafeteriaItem')
            ->whereIn('session_id', $activeSessionIds)
            ->groupBy('cafeteria_item_id')
            ->get();
        
        // Get final orders stats
        $finalOrders = FinalOrder::select('cafeteria_item_id')
            ->selectRaw('SUM(units_count) as total_quantity')
            ->selectRaw('SUM(total_price) as total_revenue')
            ->selectRaw('COUNT(*) as order_count')
            ->with('cafeteriaItem')
            ->whereIn('session_id', $endedSessionIds)
            ->groupBy('cafeteria_item_id')
            ->get();
        
        // Combine active orders
        foreach ($activeOrders as $order) {
            $unitCost = (float) ($order->cafeteriaItem->cost_price ?? 0);
            $totalQuantity = (int) $order->total_quantity;
            $totalRevenue = (float) $order->total_revenue;
            $totalCost = $totalQuantity * $unitCost;

            $combinedStats->put($order->cafeteria_item_id, [
                'cafeteriaItem' => $order->cafeteriaItem,
                'total_quantity' => $totalQuantity,
                'total_revenue' => $totalRevenue,
                'unit_cost' => $unitCost,
                'total_cost' => $totalCost,
                'actual_revenue' => $totalRevenue - $totalCost,
                'order_count' => $order->order_count,
            ]);
        }
        
        // Add final orders (combine if item already exists)
        foreach ($finalOrders as $order) {
            $existing = $combinedStats->get($order->cafeteria_item_id, [
                'cafeteriaItem' => $order->cafeteriaItem,
                'total_quantity' => 0,
                'total_revenue' => 0,
                'unit_cost' => (float) ($order->cafeteriaItem->cost_price ?? 0),
                'total_cost' => 0,
                'actual_revenue' => 0,
                'order_count' => 0,
            ]);

            $unitCost = (float) (($existing['cafeteriaItem']->cost_price ?? null) ?? ($order->cafeteriaItem->cost_price ?? 0));
            $newQuantity = (int) $existing['total_quantity'] + (int) $order->total_quantity;
            $newRevenue = (float) $existing['total_revenue'] + (float) $order->total_revenue;
            $newCost = $newQuantity * $unitCost;
            
            $combinedStats->put($order->cafeteria_item_id, [
                'cafeteriaItem' => $existing['cafeteriaItem'] ?? $order->cafeteriaItem,
                'total_quantity' => $newQuantity,
                'total_revenue' => $newRevenue,
                'unit_cost' => $unitCost,
                'total_cost' => $newCost,
                'actual_revenue' => $newRevenue - $newCost,
                'order_count' => $existing['order_count'] + $order->order_count,
            ]);
        }

        $sortedStats = $combinedStats->sortByDesc('total_quantity')->values();

        $this->cafeteriaStats = $sortedStats->all();
        $this->totalCafeteriaRevenue = (float) $sortedStats->sum('total_revenue');
        $this->totalCafeteriaCost = (float) $sortedStats->sum('total_cost');
        $this->totalCafeteriaActualRevenue = $this->totalCafeteriaRevenue - $this->totalCafeteriaCost;
        $this->totalActualRevenue = $this->totalRevenue - $this->totalCafeteriaCost;
    }
    
    private function calculateDailyStats()
    {
        $fromDateTime = Carbon::parse($this->startDate . ' ' . $this->startTime);
        $toDateTime = Carbon::parse($this->endDate . ' ' . $this->endTime);
        
        // Get daily statistics using collection methods
        $sessions = Session::whereBetween('created_at', [$fromDateTime, $toDateTime])->get();
        
        $this->dailyStats = $sessions->groupBy(function($session) {
            return $session->created_at->format('Y-m-d');
        })->map(function($dailySessions, $date) {
            $sessionCount = $dailySessions->count();
            $totalHours = $dailySessions->sum(function($session) {
                return $session->getDurationInHours();
            });
            $totalRevenue = $dailySessions->sum(function($session) {
                return $session->final_total ?? $session->calculateGrandTotal();
            });
            
            return (object) [
                'date' => $date,
                'session_count' => $sessionCount,
                'total_hours' => $totalHours,
                'total_revenue' => $totalRevenue,
                'avg_revenue_per_session' => $sessionCount > 0 ? $totalRevenue / $sessionCount : 0,
            ];
        })->sortBy('date')->values();
    }
    
    private function calculateHourlyStats()
    {
        $fromDateTime = Carbon::parse($this->startDate . ' ' . $this->startTime);
        $toDateTime = Carbon::parse($this->endDate . ' ' . $this->endTime);
        
        // Get hourly statistics using collection methods
        $sessions = Session::whereBetween('created_at', [$fromDateTime, $toDateTime])->get();
        
        $this->hourlyStats = $sessions->groupBy(function($session) {
            return $session->created_at->format('H');
        })->map(function($hourlySessions, $hour) {
            $sessionCount = $hourlySessions->count();
            $avgRevenue = $hourlySessions->avg(function($session) {
                return $session->final_total ?? $session->calculateGrandTotal();
            });
            
            return (object) [
                'hour' => intval($hour),
                'session_count' => $sessionCount,
                'avg_revenue' => $avgRevenue ?? 0,
            ];
        })->sortBy('hour')->values();
    }
    
    private function calculatePeakHours()
    {
        $this->peakHours = collect($this->hourlyStats)
            ->sortByDesc('session_count')
            ->take(3)
            ->values()
            ->all();
    }
    
    private function calculateUtilization($totalHours)
    {
        $periodDays = Carbon::parse($this->startDate)->diffInDays(Carbon::parse($this->endDate)) + 1;
        $maxPossibleHours = $periodDays * 16; // Assuming 16 hours operation per day
        
        return $maxPossibleHours > 0 ? ($totalHours / $maxPossibleHours) * 100 : 0;
    }
    
    private function calculateRevenueByDay()
    {
        $fromDate = Carbon::parse($this->startDate);
        $toDate = Carbon::parse($this->endDate);
        
        $dailyRevenue = collect();
        $current = $fromDate->copy();
        
        while ($current <= $toDate) {
            $daySessions = Session::whereDate('created_at', $current->toDateString())->get();
            $dayRevenue = $daySessions->sum(function($session) {
                return $session->final_total ?? $session->calculateGrandTotal();
            });
                
            $dailyRevenue->put($current->format('M j'), $dayRevenue);
            $current->addDay();
        }
        
        $this->revenueByDay = $dailyRevenue;
    }
    
    private function calculateRoomUtilization()
    {
        $fromDateTime = Carbon::parse($this->startDate . ' ' . $this->startTime);
        $toDateTime = Carbon::parse($this->endDate . ' ' . $this->endTime);
        
        $rooms = Room::withCount(['sessions' => function($query) use ($fromDateTime, $toDateTime) {
            $query->whereBetween('created_at', [$fromDateTime, $toDateTime]);
        }])->get();

        $this->roomUtilization = $rooms->mapWithKeys(function($room) {
            return [$room->name => $room->sessions_count];
        });
    }
    
    private function calculateDayOfWeekStats()
    {
        $fromDateTime = Carbon::parse($this->startDate . ' ' . $this->startTime);
        $toDateTime = Carbon::parse($this->endDate . ' ' . $this->endTime);
        
        $sessions = Session::whereBetween('created_at', [$fromDateTime, $toDateTime])->get();
        
        $this->dayOfWeekStats = $sessions->groupBy(function($session) {
            return $session->created_at->format('l'); // Full day name
        })->map(function($daySessions, $dayName) {
            $sessionCount = $daySessions->count();
            $revenue = $daySessions->sum(function($session) {
                return $session->final_total ?? $session->calculateGrandTotal();
            });
            $avgDuration = $daySessions->avg(function($session) {
                return $session->getDurationInHours();
            });
            
            return (object) [
                'day_name' => $dayName,
                'session_count' => $sessionCount,
                'revenue' => $revenue,
                'avg_duration' => $avgDuration ?? 0,
                'avg_revenue_per_session' => $sessionCount > 0 ? $revenue / $sessionCount : 0,
            ];
        })->sortByDesc('revenue')->values()->toArray();
    }
    
    private function calculateLast30DaysTrend()
    {
        $this->last30DaysTrend = [];
        
        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $daySessions = Session::whereDate('created_at', $date->toDateString())->get();
            
            $dayRevenue = $daySessions->sum(function($session) {
                return $session->final_total ?? $session->calculateGrandTotal();
            });
            
            $this->last30DaysTrend[] = [
                'date' => $date->format('M j'),
                'full_date' => $date->format('Y-m-d'),
                'day_name' => $date->format('D'),
                'revenue' => $dayRevenue,
                'sessions' => $daySessions->count(),
            ];
        }
    }
    
    private function calculateRevenueGoals()
    {
        // Calculate current period performance
        $currentRevenue = $this->totalRevenue;
        
        // Set realistic goals based on historical data
        $dailyGoal = 150; // Default daily goal - can be made configurable
        $weeklyGoal = 1050;
        $monthlyGoal = 4500;
        
        // Calculate period-appropriate goal
        $periodDays = Carbon::parse($this->startDate)->diffInDays(Carbon::parse($this->endDate)) + 1;
        $periodGoal = $dailyGoal * $periodDays;
        
        // Get last 30 days for comparison
        $last30DaysRevenue = Session::where('created_at', '>=', now()->subDays(30))
            ->get()
            ->sum(function($session) {
                return $session->final_total ?? $session->calculateGrandTotal();
            });
        
        $this->revenueGoals = (object) [
            'current_revenue' => $currentRevenue,
            'period_goal' => $periodGoal,
            'goal_percentage' => $periodGoal > 0 ? ($currentRevenue / $periodGoal) * 100 : 0,
            'daily_average' => $periodDays > 0 ? $currentRevenue / $periodDays : 0,
            'daily_goal' => $dailyGoal,
            'last_30_days' => $last30DaysRevenue,
            'monthly_goal' => $monthlyGoal,
            'monthly_progress' => ($last30DaysRevenue / $monthlyGoal) * 100,
        ];
    }
    
    private function calculateExecutiveSummary()
    {
        // Get comparison data (previous period)
        $periodDays = Carbon::parse($this->startDate)->diffInDays(Carbon::parse($this->endDate)) + 1;
        $previousStart = Carbon::parse($this->startDate)->subDays($periodDays);
        $previousEnd = Carbon::parse($this->endDate)->subDays($periodDays);
        
        $previousSessions = Session::whereBetween('created_at', [$previousStart, $previousEnd])->get();
        $previousRevenue = $previousSessions->sum(function($session) {
            return $session->final_total ?? $session->calculateGrandTotal();
        });
        
        // Calculate growth rates
        $revenueGrowth = $previousRevenue > 0 ? (($this->totalRevenue - $previousRevenue) / $previousRevenue) * 100 : 0;
        $sessionGrowth = $previousSessions->count() > 0 ? (($this->totalSessions - $previousSessions->count()) / $previousSessions->count()) * 100 : 0;
        
        // Find best performing metrics with safe defaults
        $bestDayName = 'N/A';
        $bestDayRevenue = 0;
        $bestRoomName = 'N/A';
        $bestRoomRevenue = 0;
        $bestHourName = 'N/A';
        
        if ($this->dayOfWeekStats && count($this->dayOfWeekStats) > 0) {
            $bestDay = $this->dayOfWeekStats[0];
            $bestDayName = $bestDay->day_name ?? 'N/A';
            $bestDayRevenue = $bestDay->revenue ?? 0;
        }
        
        if ($this->roomStats && count($this->roomStats) > 0) {
            $bestRoom = $this->roomStats[0];
            $bestRoomName = (isset($bestRoom->room) && $bestRoom->room) ? $bestRoom->room->name : 'N/A';
            $bestRoomRevenue = $bestRoom->total_revenue ?? 0;
        }
        
        if ($this->peakHours && count($this->peakHours) > 0) {
            $bestHour = $this->peakHours[0];
            $bestHourName = $bestHour->hour ?? 'N/A';
        }
        
        $this->executiveSummary = (object) [
            'revenue_growth' => $revenueGrowth,
            'session_growth' => $sessionGrowth,
            'best_day' => $bestDayName,
            'best_day_revenue' => $bestDayRevenue,
            'best_room' => $bestRoomName,
            'best_room_revenue' => $bestRoomRevenue,
            'best_hour' => $bestHourName,
            'total_customers' => $this->totalSessions, // Assuming 1 session = 1 customer group
            'avg_spend_per_customer' => $this->totalSessions > 0 ? $this->totalRevenue / $this->totalSessions : 0,
            'gaming_vs_cafeteria' => $this->totalRevenue > 0 ? ($this->totalCafeteriaRevenue / $this->totalRevenue) * 100 : 0,
        ];
    }
    
    public function clearFilters()
    {
        $this->endDate = now()->format('Y-m-d');
        $this->startDate = now()->subDays(7)->format('Y-m-d');
        $this->startTime = '00:00';
        $this->endTime = '23:59';
        $this->selectedPeriod = 'custom';
        $this->reportGenerated = false;
    }

    public function render()
    {
        return view('livewire.reports');
    }
}
