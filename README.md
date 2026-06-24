# zoroGamingHouse

Laravel + Livewire application for gaming room sessions and cafeteria ordering.

## Stock Management

This project now includes a stock-management layer for cafeteria items.

### Data Model

The `cafeteria_items` table includes:
- `price_per_item`: sale price.
- `cost_price`: optional cost per unit.
- `quantity`: optional current stock quantity.
- `barcode`: optional unique barcode.

The `stock_movements` table records every stock change with:
- item id, optional session id
- movement type (`reserve` or `release`)
- signed `quantity_change` (negative reduces stock, positive increases stock)
- quantity before and after
- source and note

### Stock Rules

- `cost_price` must be less than `price_per_item` when provided.
- Stock is warning-only when exceeded (does not hard-block).
- Talabat save uses reservation delta:
  - increase quantity for session item => reserve additional stock
  - decrease quantity for session item => release stock back
- Session finalization does not deduct stock again (prevents double counting).

### Key Flow

1. User edits items in Talabat for an active session.
2. On Save, the system computes per-item delta compared to already saved temporary orders.
3. Stock changes are applied with row-level lock.
4. Stock movement entries are written for auditability.
5. Temporary session orders are rewritten to the latest selected quantities.

### Files

Core files related to stock:
- `app/Services/StockService.php`
- `app/Models/StockMovement.php`
- `database/migrations/2026_06_25_120000_create_stock_movements_table.php`
- `app/Livewire/TalabatPage.php`
- `app/Livewire/TalabatModal.php`
- `app/Livewire/SessionSummary.php`

## Testing

A focused stock test suite exists at:
- `tests/Feature/StockManagementTest.php`

Run tests:

```bash
php artisan test --filter=StockManagementTest
```

## Migrations

Run migrations:

```bash
php artisan migrate
```

If needed in development only:

```bash
php artisan migrate:fresh --seed
```
