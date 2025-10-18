<?php

namespace App\Livewire;

use App\Models\Session;
use Livewire\Component;
use Livewire\WithPagination;

class Sessions extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $search = '';
    public $filterStatus = 'all'; // all, active, completed
    public $filterStartDate = '';
    public $filterEndDate = '';
    public $filterStartTime = '';
    public $filterEndTime = '';
    public $perPage = 12;
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    protected $listeners = [
        'refreshComponent' => '$refresh',
    ];

    protected $queryString = [
        'search' => ['except' => ''],
        'filterStatus' => ['except' => 'all'],
        'filterStartDate' => ['except' => ''],
        'filterEndDate' => ['except' => ''],
        'filterStartTime' => ['except' => ''],
        'filterEndTime' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterStatus()
    {
        $this->resetPage();
    }

    public function updatingFilterStartDate()
    {
        $this->resetPage();
    }

    public function updatingFilterEndDate()
    {
        $this->resetPage();
    }

    public function updatingFilterStartTime()
    {
        $this->resetPage();
    }

    public function updatingFilterEndTime()
    {
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->filterStatus = 'all';
        $this->filterStartDate = '';
        $this->filterEndDate = '';
        $this->filterStartTime = '';
        $this->filterEndTime = '';
        $this->resetPage();
    }

    public function render()
    {
        $query = Session::with(['room', 'orders', 'finalOrders']);

        // Apply sorting
        if ($this->sortField === 'room_name') {
            $query->join('rooms', 'gaming_sessions.room_id', '=', 'rooms.id')
                ->orderBy('rooms.name', $this->sortDirection)
                ->select('gaming_sessions.*');
        } else {
            $query->orderBy($this->sortField, $this->sortDirection);
        }

        // Search filter
        if (!empty($this->search)) {
            $query->whereHas('room', function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%');
            });
        }

        // Status filter
        if ($this->filterStatus === 'active') {
            $query->where('is_active', true);
        } elseif ($this->filterStatus === 'completed') {
            $query->where('is_active', false);
        }

        // Date range filters
        if (!empty($this->filterStartDate)) {
            $startDateTime = $this->filterStartDate;
            if (!empty($this->filterStartTime)) {
                $startDateTime .= ' ' . $this->filterStartTime;
            } else {
                $startDateTime .= ' 00:00:00';
            }
            $query->where('started_at', '>=', $startDateTime);
        }

        if (!empty($this->filterEndDate)) {
            $endDateTime = $this->filterEndDate;
            if (!empty($this->filterEndTime)) {
                $endDateTime .= ' ' . $this->filterEndTime;
            } else {
                $endDateTime .= ' 23:59:59';
            }
            $query->where('started_at', '<=', $endDateTime);
        }

        // Time-only filters (when no date is specified)
        if (empty($this->filterStartDate) && empty($this->filterEndDate)) {
            if (!empty($this->filterStartTime)) {
                $query->whereTime('started_at', '>=', $this->filterStartTime);
            }
            if (!empty($this->filterEndTime)) {
                $query->whereTime('started_at', '<=', $this->filterEndTime);
            }
        }

        // Get all filtered sessions for statistics
        $allFilteredSessions = $query->get();

        // Paginate the sessions
        $sessions = $query->paginate($this->perPage);

        // Calculate summary statistics based on filtered results
        $stats = [
            'total_sessions' => $allFilteredSessions->count(),
            'active_sessions' => $allFilteredSessions->where('is_active', true)->count(),
            'completed_sessions' => $allFilteredSessions->where('is_active', false)->count(),
            'average_duration' => $this->calculateAverageDuration($allFilteredSessions),
        ];

        return view('livewire.sessions', compact('sessions', 'stats'));
    }

    private function calculateFilteredRevenue($sessions)
    {
        $totalRevenue = 0;

        foreach ($sessions->where('is_active', false) as $session) {
            // Use final_total if available, otherwise calculate grand total
            $totalRevenue += $session->final_total ?? $session->calculateGrandTotal();
        }

        return $totalRevenue;
    }

    private function calculateAverageDuration($sessions)
    {
        $completedSessions = $sessions->where('is_active', false);
        
        if ($completedSessions->count() === 0) {
            return '0h 0m';
        }

        $totalMinutes = 0;
        foreach ($completedSessions as $session) {
            $totalMinutes += $session->getDurationInMinutes();
        }

        $averageMinutes = $totalMinutes / $completedSessions->count();
        $hours = floor($averageMinutes / 60);
        $minutes = round($averageMinutes % 60);

        return $hours . 'h ' . $minutes . 'm';
    }

    public function sortBy($field, $direction = 'desc')
    {
        $this->sortField = $field;
        $this->sortDirection = $direction;
        $this->resetPage();
    }
}
