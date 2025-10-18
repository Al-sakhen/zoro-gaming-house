<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rooms = [
            [
                'name' => 'Room A1',
                'price_per_hour' => 15.00,
                'is_vip' => false,
                'status' => 'available',
            ],
            [
                'name' => 'Room A2',
                'price_per_hour' => 15.00,
                'is_vip' => false,
                'status' => 'available',
            ],
            [
                'name' => 'Room B1',
                'price_per_hour' => 15.00,
                'is_vip' => false,
                'status' => 'available',
            ],
            [
                'name' => 'VIP Room 1',
                'price_per_hour' => 25.00,
                'is_vip' => true,
                'status' => 'available',
            ],
            [
                'name' => 'VIP Room 2',
                'price_per_hour' => 25.00,
                'is_vip' => true,
                'status' => 'available',
            ],
            [
                'name' => 'Room C1',
                'price_per_hour' => 15.00,
                'is_vip' => false,
                'status' => 'maintenance',
            ],
        ];

        foreach ($rooms as $room) {
            Room::create($room);
        }
    }
}
