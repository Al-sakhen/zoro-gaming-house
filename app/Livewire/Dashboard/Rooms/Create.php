<?php

namespace App\Livewire\Dashboard\Rooms;

use App\Models\Room;
use Livewire\Component;

class Create extends Component
{
    public $name = '';
    public $type = 'playstation';
    public $price_per_hour = '';
    public $price_per_hour_2_controllers = '';
    public $price_per_hour_4_controllers = '';
    public $is_vip = false;
    public $status = 'available';

    protected $rules = [
        'name' => 'required|string|max:255',
        'type' => 'required|in:playstation,pc,tables',
        'price_per_hour' => 'required|numeric|min:0',
        'price_per_hour_2_controllers' => 'nullable|numeric|min:0',
        'price_per_hour_4_controllers' => 'nullable|numeric|min:0',
        'is_vip' => 'boolean',
        'status' => 'required|in:available,occupied,maintenance',
    ];

    protected $messages = [
        'name.required' => 'Room name is required.',
        'name.max' => 'Room name cannot exceed 255 characters.',
        'type.required' => 'Room type is required.',
        'type.in' => 'Room type must be one of: PlayStation, PC, or Tables.',
        'price_per_hour.required' => 'Price per hour is required.',
        'price_per_hour.numeric' => 'Price per hour must be a valid number.',
        'price_per_hour.min' => 'Price per hour cannot be negative.',
        'price_per_hour_2_controllers.numeric' => 'Price for 2 controllers must be a valid number.',
        'price_per_hour_2_controllers.min' => 'Price for 2 controllers cannot be negative.',
        'price_per_hour_4_controllers.numeric' => 'Price for 4 controllers must be a valid number.',
        'price_per_hour_4_controllers.min' => 'Price for 4 controllers cannot be negative.',
        'status.required' => 'Status is required.',
        'status.in' => 'Status must be one of: available, occupied, maintenance.',
    ];

    public function save()
    {
        // Dynamic validation based on room type
        $rules = $this->rules;

        // For PlayStation rooms, price_per_hour can be optional if controller prices are provided
        if ($this->type === 'playstation') {
            $rules['price_per_hour'] = 'nullable|numeric|min:0';
            // At least one pricing method should be provided for PlayStation
            $this->validate($rules, $this->messages, [
                'price_per_hour' => 'Base Price Per Hour',
                'price_per_hour_2_controllers' => '2 Controllers Price',
                'price_per_hour_4_controllers' => '4 Controllers Price',
            ]);

            // Custom validation: PlayStation rooms need at least one pricing method
            if (empty($this->price_per_hour) && empty($this->price_per_hour_2_controllers) && empty($this->price_per_hour_4_controllers)) {
                $this->addError('price_per_hour', 'PlayStation rooms require at least one pricing method (base price, 2-controller price, or 4-controller price).');
                return;
            }
        } else {
            $this->validate($rules, $this->messages);
        }

        // Set pricing defaults based on room type
        $data = [
            'name' => $this->name,
            'type' => $this->type,
            'price_per_hour' => $this->price_per_hour ?: 0,
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

        Room::create($data);

        $this->dispatch('success', 'Room created successfully!');
        $this->dispatch('closeCreateModal');
        $this->dispatch('refreshTable');
        // Reset form
        $this->reset(['name', 'type', 'price_per_hour', 'price_per_hour_2_controllers', 'price_per_hour_4_controllers', 'is_vip', 'status']);
    }

    public function render()
    {
        return view('livewire.dashboard.rooms.create');
    }
}
