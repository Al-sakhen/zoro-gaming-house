<?php

namespace App\Livewire;

use App\Models\Room;
use Livewire\Component;
use Livewire\Attributes\Validate;

class RoomManager extends Component
{
    #[Validate('required|string|max:255')]
    public $name = '';

    #[Validate('required|in:playstation,pc,tables')]
    public $type = 'pc';

    #[Validate('required|numeric|min:0')]
    public $price_per_hour = '';

    #[Validate('nullable|numeric|min:0')]
    public $price_per_hour_2_controllers = '';

    #[Validate('nullable|numeric|min:0')]
    public $price_per_hour_4_controllers = '';

    #[Validate('boolean')]
    public $is_vip = false;

    #[Validate('nullable|in:available,occupied,maintenance')]
    public $status = null;

    public $editingRoom = null;
    public $showForm = false;

    public function mount()
    {
        //
    }

    public function createRoom()
    {
        $this->resetForm();
        $this->showForm = true;
        $this->editingRoom = null;
    }

    public function editRoom(Room $room)
    {
        $this->editingRoom = $room;
        $this->name = $room->name;
        $this->type = $room->type;
        $this->price_per_hour = $room->price_per_hour;
        $this->price_per_hour_2_controllers = $room->price_per_hour_2_controllers;
        $this->price_per_hour_4_controllers = $room->price_per_hour_4_controllers;
        $this->is_vip = $room->is_vip;
        $this->status = $room->status;
        $this->showForm = true;
    }

    public function saveRoom()
    {
        $this->validate();

        // Set pricing defaults based on room type
        $data = [
            'name' => $this->name,
            'type' => $this->type,
            'price_per_hour' => $this->price_per_hour,
            'is_vip' => $this->is_vip,
            'status' => $this->status,
        ];

        // Only set PlayStation pricing if room type is PlayStation
        if ($this->type === 'playstation') {
            $data['price_per_hour_2_controllers'] = $this->price_per_hour_2_controllers;
            $data['price_per_hour_4_controllers'] = $this->price_per_hour_4_controllers;
        } else {
            $data['price_per_hour_2_controllers'] = null;
            $data['price_per_hour_4_controllers'] = null;
        }

        if ($this->editingRoom) {
            $this->editingRoom->update($data);
        } else {
            Room::create($data);
        }

        $this->resetForm();
        $this->showForm = false;
        
        session()->flash('message', $this->editingRoom ? 'Room updated successfully!' : 'Room created successfully!');
    }

    public function deleteRoom(Room $room)
    {
        $room->delete();
        session()->flash('message', 'Room deleted successfully!');
    }

    public function resetForm()
    {
        $this->name = '';
        $this->type = 'pc';
        $this->price_per_hour = '';
        $this->price_per_hour_2_controllers = '';
        $this->price_per_hour_4_controllers = '';
        $this->is_vip = false;
        $this->status = null;
        $this->editingRoom = null;
        $this->resetErrorBag();
    }

    public function cancelEdit()
    {
        $this->resetForm();
        $this->showForm = false;
    }

    public function render()
    {
        return view('livewire.room-manager', [
            'rooms' => Room::orderBy('name')->get()
        ]);
    }
}
