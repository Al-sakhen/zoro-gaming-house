# Stock Management Reference

Date: 2026-06-25
Project: zoroGamingHouse
Purpose: Full reference of stock-management related work completed in this implementation, including affected pages/components and exact behavior.

## 1) Scope Summary

The stock-management implementation now includes:
- Item fields: quantity, barcode (nullable, unique), cost_price.
- Validation and UI updates across cafeteria management screens.
- Barcode-assisted add flow in Talabat.
- Warning alerts when requested quantity exceeds available stock (warning-only policy).
- Live stock reservation during active sessions, with delta-based restore when quantities are reduced before session close.
- Session finalization updated to avoid double stock deduction.
- Cafeteria overview enhanced with Actual Revenue (revenue - estimated cost).
- Full stock movement audit ledger with movement type, before/after, source, and session context.
- Dedicated stock control modal for manual stock operations.
- Stock movements modal pagination and filtering.

## 2) Database Changes

Changed files:
- database/migrations/2026_06_19_120000_add_stock_fields_to_cafeteria_items_table.php
- database/migrations/2026_06_25_120000_create_stock_movements_table.php

Change details:
- cafeteria_items updates:
  - barcode: nullable unique string.
  - cost_price: nullable decimal(8,2).
  - quantity: nullable integer.
- stock_movements table:
  - cafeteria_item_id (required FK).
  - session_id (nullable FK to gaming_sessions).
  - movement_type (reserve, release, manual_in, manual_out, manual_set).
  - quantity_change (signed integer).
  - quantity_before and quantity_after.
  - source and note.
  - timestamps and indexes for lookup.

## 3) Core Models and Service

Changed files:
- app/Models/CafeteriaItem.php
- app/Models/StockMovement.php
- app/Services/StockService.php

Change details:
- CafeteriaItem:
  - Added fillable fields: barcode, cost_price, quantity.
  - Added casts: cost_price float, quantity integer.
  - Added relation: stockMovements().
- StockMovement:
  - New model for stock audit records.
- StockService:
  - applyReservationDelta(itemId, reservationDelta, sessionId, source, note)
    - +N reservation delta reduces stock by N.
    - -N reservation delta releases stock by N.
    - Uses lockForUpdate and writes stock_movements records.
  - applyManualDelta(itemId, quantityDelta, source, note)
    - +N adds stock (manual_in).
    - -N removes stock (manual_out).
    - Uses DB transaction and lockForUpdate.
  - setAbsoluteQuantity(itemId, newQuantity, source, note)
    - Sets stock to exact value.
    - Logs movement_type manual_set with computed delta.

## 4) Cafeteria Item Management UI

### 4.1 Main Cafeteria Manager
Changed files:
- app/Livewire/CafeteriaManager.php
- resources/views/livewire/cafeteria-manager.blade.php

What changed:
- Added fields: barcode, cost_price, quantity.
- Added validation and nullable normalization.
- Added display columns for barcode, cost price, and quantity.

### 4.2 Dashboard Cafeteria Create/Edit Modals
Changed files:
- app/Livewire/Dashboard/Cafeteria/Create.php
- app/Livewire/Dashboard/Cafeteria/Edit.php
- resources/views/livewire/dashboard/cafeteria/create.blade.php
- resources/views/livewire/dashboard/cafeteria/edit.blade.php

What changed:
- Create modal supports barcode, cost_price, quantity.
- Edit modal supports barcode and cost_price, but quantity control was removed from edit flow.
- Quantity changes are now handled through dedicated stock-control flow.

### 4.3 Dashboard PowerGrid Cafeteria Table
Changed file:
- app/Livewire/Tables/CafteriaItemTable.php

What changed:
- Added grid fields/columns for cost price and stock quantity formatting.
- Action column moved to first column for quick operations.
- Added row action buttons:
  - Edit.
  - Stock Movements.
  - Stock Control.
- Updated to solid button styles and existing icons:
  - Edit: fas fa-edit, btn-primary.
  - Stock Movements: fas fa-chart-line, btn-info.
  - Stock Control: fas fa-cogs, btn-success.

## 5) Stock Modals from Cafeteria Table

### 5.1 Stock Movements Modal
Changed files:
- app/Livewire/Dashboard/Cafeteria/StockMovements.php
- resources/views/livewire/dashboard/cafeteria/stock-movements.blade.php
- resources/views/admin/cafeteria/index.blade.php

What changed:
- Opened from PowerGrid row action.
- Shows stock movement history per selected item.
- Added movement-type badges for:
  - reserve
  - release
  - manual_in
  - manual_out
  - manual_set
- Added pagination:
  - 20 rows per page.
  - newest first.
- Added filters:
  - movement type
  - source (contains)
  - session ID
  - date from
  - date to
  - clear filters action

### 5.2 Stock Control Modal
Changed files:
- app/Livewire/Dashboard/Cafeteria/StockControl.php
- resources/views/livewire/dashboard/cafeteria/stock-control.blade.php
- resources/views/admin/cafeteria/index.blade.php

What changed:
- Opened from PowerGrid row action.
- Supports stock operations for selected item:
  - increment by step
  - decrement by step
  - set absolute quantity
- Updates are persisted via StockService.
- Writes audit ledger entries to stock_movements.
- Dispatches refreshTable after update.
- Modal closes automatically after successful submit (same behavior style as edit modal).

## 6) Talabat Ordering and Stock Reservation

### 6.1 Talabat Page (active runtime path)
Changed files:
- app/Livewire/TalabatPage.php
- resources/views/livewire/talabat-page.blade.php

What changed:
- Barcode add flow and barcode-aware search.
- Warning UI and warning-only stock policy.
- Save button always active.
- closeTalabatWindow event behavior retained.

Stock behavior on TalabatPage:
- On save, stock updates using reservation delta vs previously saved session quantities.
- Positive delta reserves more stock.
- Negative delta releases stock back.
- Uses StockService and logs reserve/release movements.

### 6.2 Talabat Modal
Changed files:
- app/Livewire/TalabatModal.php
- resources/views/livewire/talabat-modal.blade.php

What changed:
- Barcode flow, warnings, always-active save button.
- Stock reservation logic integrated with StockService.

Important usage note:
- Dashboard currently uses TalabatPage (new tab) as primary runtime flow.

## 7) Session Finalization Behavior

Changed file:
- app/Livewire/SessionSummary.php

What changed:
- confirmEndSession wrapped in DB transaction with lockForUpdate.
- Added finalized-session guard.
- Removed finalization-time stock deduction.

Reason:
- Stock is already updated during active-session saves, so finalization deduction would double count.

## 8) Cafeteria Overview Revenue Enhancements

Changed files:
- app/Livewire/CafeteriaOverview.php
- resources/views/livewire/cafeteria-overview.blade.php

What changed:
- Added metrics:
  - total_cost = total_quantity x cost_price.
  - actual_revenue = total_revenue - total_cost.
- Added summary and sort/display support for actual revenue.

## 9) Full Verified Changed Files List

Backend and data:
- database/migrations/2026_06_19_120000_add_stock_fields_to_cafeteria_items_table.php
- database/migrations/2026_06_25_120000_create_stock_movements_table.php
- app/Models/CafeteriaItem.php
- app/Models/StockMovement.php
- app/Services/StockService.php
- app/Livewire/CafeteriaManager.php
- app/Livewire/Dashboard/Cafeteria/Create.php
- app/Livewire/Dashboard/Cafeteria/Edit.php
- app/Livewire/Dashboard/Cafeteria/StockMovements.php
- app/Livewire/Dashboard/Cafeteria/StockControl.php
- app/Livewire/Tables/CafteriaItemTable.php
- app/Livewire/TalabatModal.php
- app/Livewire/TalabatPage.php
- app/Livewire/SessionSummary.php
- app/Livewire/CafeteriaOverview.php

Views and pages:
- resources/views/admin/cafeteria/index.blade.php
- resources/views/livewire/cafeteria-manager.blade.php
- resources/views/livewire/dashboard/cafeteria/create.blade.php
- resources/views/livewire/dashboard/cafeteria/edit.blade.php
- resources/views/livewire/dashboard/cafeteria/stock-movements.blade.php
- resources/views/livewire/dashboard/cafeteria/stock-control.blade.php
- resources/views/livewire/talabat-modal.blade.php
- resources/views/livewire/talabat-page.blade.php
- resources/views/livewire/cafeteria-overview.blade.php

Tests and docs:
- tests/Feature/StockManagementTest.php
- README.md
- STOCK_MANAGEMENT_REFERENCE.md

## 10) Current Functional Rules (Stock Management)

- price_per_item is sale price.
- barcode is optional and unique when provided.
- quantity is nullable for legacy/unmanaged stock items.
- cost_price is optional and must be less than price_per_item when provided.
- Exceeding stock triggers warning alerts (warning-only policy).
- Save button is always active in Talabat views.
- Active-session stock updates happen on save using reservation delta logic.
- Session finalization does not modify stock quantities.
- Manual stock changes must go through Stock Control modal.
- Every tracked stock change writes a stock_movements audit record.

## 11) Verification Notes

- Migrations executed successfully.
- Stock test suite executed successfully:
  - tests/Feature/StockManagementTest.php
  - 5 passing tests, 17 assertions (latest run).
- Edited files were checked for compile/lint issues after major patches.

## 12) Recommended Future Improvement

For historical profit accuracy, store cost_price snapshots in orders/final_orders at order time. Current overview cost uses current item cost_price as an estimate.