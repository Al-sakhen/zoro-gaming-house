<?php

use App\Livewire\TalabatPage;
use App\Livewire\Dashboard\Cafeteria\StockControl;
use App\Models\CafeteriaItem;
use App\Models\Order;
use App\Models\Room;
use App\Models\Session;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

function createSessionContext(int $stockQuantity = 10): array
{
    $room = Room::query()->create([
        'name' => 'Stock Test Room',
        'type' => 'pc',
        'price_per_hour' => 10,
        'is_vip' => false,
        'status' => 'occupied',
    ]);

    $session = Session::query()->create([
        'room_id' => $room->id,
        'started_at' => now(),
        'is_active' => true,
    ]);

    $item = CafeteriaItem::query()->create([
        'name' => 'Cola',
        'price_per_item' => 2.00,
        'cost_price' => 1.00,
        'quantity' => $stockQuantity,
        'status' => 1,
    ]);

    return [$room, $session, $item];
}

it('releases reserved stock when session order quantity is reduced before session close', function () {
    [, $session, $item] = createSessionContext(6);

    Order::query()->create([
        'session_id' => $session->id,
        'cafeteria_item_id' => $item->id,
        'units_count' => 4,
        'price_per_unit' => 2.00,
        'total_price' => 8.00,
    ]);

    Livewire::test(TalabatPage::class, ['session' => $session])
        ->set("selectedItems.{$item->id}.quantity", 2)
        ->set("selectedItems.{$item->id}.total", 4.00)
        ->call('saveOrders')
        ->assertDispatched('closeTalabatWindow');

    expect($item->refresh()->quantity)->toBe(8);
    expect((int) Order::query()->where('session_id', $session->id)->sum('units_count'))->toBe(2);

    $this->assertDatabaseHas('stock_movements', [
        'cafeteria_item_id' => $item->id,
        'session_id' => $session->id,
        'movement_type' => 'release',
        'quantity_change' => 2,
        'quantity_before' => 6,
        'quantity_after' => 8,
        'source' => 'talabat_page_save',
    ]);
});

it('still reserves when requested quantity exceeds available stock', function () {
    [, $session, $item] = createSessionContext(3);

    Livewire::test(TalabatPage::class, ['session' => $session])
        ->set("selectedItems.{$item->id}.quantity", 8)
        ->set("selectedItems.{$item->id}.total", 16.00)
        ->call('saveOrders')
        ->assertDispatched('closeTalabatWindow');

    expect($item->refresh()->quantity)->toBe(-5);

    $this->assertDatabaseHas('stock_movements', [
        'cafeteria_item_id' => $item->id,
        'session_id' => $session->id,
        'movement_type' => 'reserve',
        'quantity_change' => -8,
        'quantity_before' => 3,
        'quantity_after' => -5,
        'source' => 'talabat_page_save',
    ]);
});

it('logs both reserve and release movements for the same session item', function () {
    [, $session, $item] = createSessionContext(10);

    $component = Livewire::test(TalabatPage::class, ['session' => $session]);

    $component
        ->set("selectedItems.{$item->id}.quantity", 4)
        ->set("selectedItems.{$item->id}.total", 8.00)
        ->call('saveOrders');

    $component
        ->set("selectedItems.{$item->id}.quantity", 2)
        ->set("selectedItems.{$item->id}.total", 4.00)
        ->call('saveOrders');

    expect($item->refresh()->quantity)->toBe(8);

    $reserveCount = \App\Models\StockMovement::query()
        ->where('cafeteria_item_id', $item->id)
        ->where('movement_type', 'reserve')
        ->count('*');

    $releaseCount = \App\Models\StockMovement::query()
        ->where('cafeteria_item_id', $item->id)
        ->where('movement_type', 'release')
        ->count('*');

    expect($reserveCount)->toBe(1);
    expect($releaseCount)->toBe(1);
});

it('increments and decrements stock through stock control modal component', function () {
    [, , $item] = createSessionContext(10);

    $component = Livewire::test(StockControl::class)
        ->call('setStockControlCafeteriaItem', $item)
        ->set('step', 3)
        ->call('increment')
        ->set('step', 2)
        ->call('decrement');

    $component->assertDispatched('refreshTable');

    expect($item->refresh()->quantity)->toBe(11);

    $this->assertDatabaseHas('stock_movements', [
        'cafeteria_item_id' => $item->id,
        'movement_type' => 'manual_in',
        'quantity_change' => 3,
        'quantity_before' => 10,
        'quantity_after' => 13,
        'source' => 'stock_control_modal_delta',
    ]);

    $this->assertDatabaseHas('stock_movements', [
        'cafeteria_item_id' => $item->id,
        'movement_type' => 'manual_out',
        'quantity_change' => -2,
        'quantity_before' => 13,
        'quantity_after' => 11,
        'source' => 'stock_control_modal_delta',
    ]);
});

it('sets absolute stock quantity through stock control modal component', function () {
    [, , $item] = createSessionContext(7);

    Livewire::test(StockControl::class)
        ->call('setStockControlCafeteriaItem', $item)
        ->set('setQuantity', 20)
        ->call('setAbsolute')
        ->assertDispatched('refreshTable');

    expect($item->refresh()->quantity)->toBe(20);

    $this->assertDatabaseHas('stock_movements', [
        'cafeteria_item_id' => $item->id,
        'movement_type' => 'manual_set',
        'quantity_change' => 13,
        'quantity_before' => 7,
        'quantity_after' => 20,
        'source' => 'stock_control_modal_set',
    ]);
});
