<?php

namespace App\Livewire;

use App\Models\Room;
use App\Models\Session;
use App\Models\Order;
use App\Models\FinalOrder;
use Carbon\Carbon;
use Livewire\Component;

class Dashboard extends Component
{
    public $selectedSession = null;
    public $showOrderDialog = false;
    public $showControllerDialog = false;
    public $selectedRoom = null;
    public $search = '';
    public $statusFilter = 'all'; // 'all', 'available', 'occupied'

    protected $listeners = [
        'sessionStopped' => 'refreshRooms', 
        'closeDialog' => 'closeOrderDialog',
        'refreshComponent' => 'refreshRooms',
        'closeControllerDialog' => 'closeControllerDialog'
    ];

    public function updatedSearch()
    {
        // This method will be called automatically when search property is updated
        // It will trigger a re-render of the component
    }

    public function updatedStatusFilter()
    {
        // This method will be called automatically when statusFilter property is updated
        // It will trigger a re-render of the component
    }

    public function setStatusFilter($status)
    {
        $this->statusFilter = $status;
    }

    public function startSession(Room $room)
    {
        if ($room->isOccupied()) {
            session()->flash('error', 'Room is already occupied!');
            return;
        }

        // If it's a PlayStation room, show controller selection dialog
        if ($room->isPlaystation()) {
            $this->selectedRoom = $room;
            $this->showControllerDialog = true;
            return;
        }

        // For non-PlayStation rooms, start session directly
        $this->createSession($room, null);
    }

    public function startSessionWithControllers($controllerCount)
    {
        if (!$this->selectedRoom) {
            session()->flash('error', 'No room selected!');
            return;
        }

        $this->createSession($this->selectedRoom, $controllerCount);
        $this->closeControllerDialog();
    }

    protected function createSession(Room $room, $controllerCount = null)
    {
        Session::create([
            'room_id' => $room->id,
            'controller_count' => $controllerCount,
            'started_at' => now(),
            'is_active' => true,
        ]);

        // Update room status
        $room->update(['status' => 'occupied']);

        $sessionType = $controllerCount ? " with {$controllerCount} controllers" : "";
        session()->flash('message', "Timer started for {$room->name}{$sessionType}!");
    }

    public function closeControllerDialog()
    {
        $this->showControllerDialog = false;
        $this->selectedRoom = null;
    }

    public function stopSession(Room $room)
    {
        $session = $room->activeSession();

        if (!$session) {
            session()->flash('error', 'No active session found for this room!');
            return;
        }

        // Temporarily set the ended_at time to stop billing calculation
        // but keep session as active for confirmation
        $session->update([
            'ended_at' => now(),
        ]);

        // Open session summary popup
        $this->dispatch('openSessionSummaryWindow', route('session.summary', $session));
    }

    public function openOrderDialog($sessionId)
    {
        $this->dispatch('openTalabatWindow', route('talabat', $sessionId));
    }

    public function refreshRooms()
    {
        $this->render();
    }

    public function getSessionDuration($session)
    {
        if (!$session) return '00:00:00';
        
        return $session->getDurationHHMMSS();
    }

    public function render()
    {
        $query = Room::with('sessions');
        
        // Apply search filter if search term exists
        if (!empty($this->search)) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }
        
        // Apply status filter - only show available and occupied rooms (exclude maintenance)
        $query->whereIn('status', ['available', 'occupied']);
        
        // Additional status filtering if specific status is selected
        if ($this->statusFilter !== 'all') {
            $query->where('status', $this->statusFilter);
        }
        
        // Special ordering for occupied rooms - oldest session first
        if ($this->statusFilter === 'occupied') {
            $rooms = $query->leftJoin('gaming_sessions', function($join) {
                            $join->on('rooms.id', '=', 'gaming_sessions.room_id')
                                 ->where('gaming_sessions.is_active', true);
                        })
                        ->orderBy('gaming_sessions.started_at', 'asc')
                        ->select('rooms.*')
                        ->get();
        } else {
            // Default ordering: Non-VIP rooms first (is_vip = 0), VIP rooms last (is_vip = 1), then by name
            $rooms = $query->orderBy('is_vip', 'asc')
                          ->orderBy('name', 'asc')
                          ->get();
        }

        return view('livewire.dashboard', [
            'rooms' => $rooms
        ]);
    }
}
