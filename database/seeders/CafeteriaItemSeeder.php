<?php

namespace Database\Seeders;

use App\Models\CafeteriaItem;
use Illuminate\Database\Seeder;

class CafeteriaItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            ['name' => 'Coffee', 'price_per_item' => 1.50, 'status' => 1],
            ['name' => 'Tea', 'price_per_item' => 1.00, 'status' => 1],
            ['name' => 'Energy Drink', 'price_per_item' => 2.00, 'status' => 1],
            ['name' => 'Sandwich', 'price_per_item' => 3.50, 'status' => 1],
            ['name' => 'Chips', 'price_per_item' => 0.50, 'status' => 1],
            ['name' => 'Pizza Slice', 'price_per_item' => 2.50, 'status' => 1],
            ['name' => 'Water Bottle', 'price_per_item' => 0.75, 'status' => 1],
            ['name' => 'Shisha', 'price_per_item' => 5.00, 'status' => 1],
        ];

        foreach ($items as $item) {
            CafeteriaItem::create($item);
        }
    }
}
