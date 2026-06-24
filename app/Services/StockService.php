<?php

namespace App\Services;

use App\Models\CafeteriaItem;
use App\Models\StockMovement;
use Illuminate\Support\Facades\DB;

class StockService
{
    /**
     * Reservation delta semantics:
     * +N => reserve N units (stock decreases)
     * -N => release N units (stock increases)
     */
    public function applyReservationDelta(
        int $itemId,
        int $reservationDelta,
        ?int $sessionId,
        string $source,
        ?string $note = null
    ): array {
        $item = CafeteriaItem::query()->whereKey($itemId)->lockForUpdate()->firstOrFail();

        if ($item->quantity === null || $reservationDelta === 0) {
            return [
                'item' => $item,
                'tracked' => false,
                'before' => $item->quantity,
                'after' => $item->quantity,
            ];
        }

        $before = (int) $item->quantity;
        $quantityChange = -$reservationDelta; // stock movement direction
        $after = $before + $quantityChange;

        $item->update(['quantity' => $after]);
        $item->quantity = $after;

        StockMovement::create([
            'cafeteria_item_id' => $item->id,
            'session_id' => $sessionId,
            'movement_type' => $quantityChange < 0 ? 'reserve' : 'release',
            'quantity_change' => $quantityChange,
            'quantity_before' => $before,
            'quantity_after' => $after,
            'source' => $source,
            'note' => $note,
        ]);

        return [
            'item' => $item,
            'tracked' => true,
            'before' => $before,
            'after' => $after,
        ];
    }

    /**
     * Manual delta semantics:
     * +N => add stock
     * -N => remove stock
     */
    public function applyManualDelta(
        int $itemId,
        int $quantityDelta,
        string $source,
        ?string $note = null
    ): array {
        return DB::transaction(function () use ($itemId, $quantityDelta, $source, $note) {
            $item = CafeteriaItem::query()->whereKey($itemId)->lockForUpdate()->firstOrFail();

            $before = $item->quantity === null ? 0 : (int) $item->quantity;
            if ($quantityDelta === 0) {
                return [
                    'item' => $item,
                    'tracked' => false,
                    'before' => $before,
                    'after' => $before,
                ];
            }

            $after = $before + $quantityDelta;
            $item->update(['quantity' => $after]);
            $item->quantity = $after;

            StockMovement::create([
                'cafeteria_item_id' => $item->id,
                'session_id' => null,
                'movement_type' => $quantityDelta > 0 ? 'manual_in' : 'manual_out',
                'quantity_change' => $quantityDelta,
                'quantity_before' => $before,
                'quantity_after' => $after,
                'source' => $source,
                'note' => $note,
            ]);

            return [
                'item' => $item,
                'tracked' => true,
                'before' => $before,
                'after' => $after,
            ];
        });
    }

    public function setAbsoluteQuantity(
        int $itemId,
        int $newQuantity,
        string $source,
        ?string $note = null
    ): array {
        return DB::transaction(function () use ($itemId, $newQuantity, $source, $note) {
            $item = CafeteriaItem::query()->whereKey($itemId)->lockForUpdate()->firstOrFail();

            $before = $item->quantity === null ? 0 : (int) $item->quantity;
            $delta = $newQuantity - $before;

            if ($delta === 0) {
                return [
                    'item' => $item,
                    'tracked' => false,
                    'before' => $before,
                    'after' => $before,
                ];
            }

            $item->update(['quantity' => $newQuantity]);
            $item->quantity = $newQuantity;

            StockMovement::create([
                'cafeteria_item_id' => $item->id,
                'session_id' => null,
                'movement_type' => 'manual_set',
                'quantity_change' => $delta,
                'quantity_before' => $before,
                'quantity_after' => $newQuantity,
                'source' => $source,
                'note' => $note,
            ]);

            return [
                'item' => $item,
                'tracked' => true,
                'before' => $before,
                'after' => $newQuantity,
            ];
        });
    }
}
