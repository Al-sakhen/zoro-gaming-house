<?php

namespace App\Livewire;

use App\Models\FinalOrder;
use App\Models\CafeteriaItem;
use Livewire\Component;
use Livewire\WithPagination;

class CafeteriaOverview extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $search = '';
    public $filterName = '';
    public $filterStartDate = '';
    public $filterEndDate = '';
    public $filterStartTime = '';
    public $filterEndTime = '';
    public $filterMinQuantity = '';
    public $filterMaxQuantity = '';
    public $perPage = 12;
    public $sortField = 'total_quantity';
    public $sortDirection = 'desc';

    protected $listeners = [
        'refreshComponent' => '$refresh',
    ];

    protected $queryString = [
        'search' => ['except' => ''],
        'filterName' => ['except' => ''],
        'filterStartDate' => ['except' => ''],
        'filterEndDate' => ['except' => ''],
        'filterStartTime' => ['except' => ''],
        'filterEndTime' => ['except' => ''],
        'filterMinQuantity' => ['except' => ''],
        'filterMaxQuantity' => ['except' => ''],
        'sortField' => ['except' => 'total_quantity'],
        'sortDirection' => ['except' => 'desc'],
        'page' => ['except' => 1],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterName()
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

    public function updatingFilterMinQuantity()
    {
        $this->resetPage();
    }

    public function updatingFilterMaxQuantity()
    {
        $this->resetPage();
    }

    public function updatingPage()
    {
        // Ensure page updates are handled properly
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->filterName = '';
        $this->filterStartDate = '';
        $this->filterEndDate = '';
        $this->filterStartTime = '';
        $this->filterEndTime = '';
        $this->filterMinQuantity = '';
        $this->filterMaxQuantity = '';
        $this->resetPage();
    }

    public function render()
    {
        $query = FinalOrder::with(['cafeteriaItem', 'session', 'session.room']);

        // Apply filters before grouping
        // Search filter (search in cafeteria item name only)
        if (!empty($this->search)) {
            $query->whereHas('cafeteriaItem', function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%');
            });
        }

        // Filter by cafeteria item name
        if (!empty($this->filterName)) {
            $query->whereHas('cafeteriaItem', function ($q) {
                $q->where('name', 'like', '%' . $this->filterName . '%');
            });
        }

        // Date range filters (using session created_at)
        if (!empty($this->filterStartDate)) {
            $startDateTime = $this->filterStartDate;
            if (!empty($this->filterStartTime)) {
                $startDateTime .= ' ' . $this->filterStartTime;
            } else {
                $startDateTime .= ' 00:00:00';
            }
            $query->whereHas('session', function ($q) use ($startDateTime) {
                $q->where('started_at', '>=', $startDateTime);
            });
        }

        if (!empty($this->filterEndDate)) {
            $endDateTime = $this->filterEndDate;
            if (!empty($this->filterEndTime)) {
                $endDateTime .= ' ' . $this->filterEndTime;
            } else {
                $endDateTime .= ' 23:59:59';
            }
            $query->whereHas('session', function ($q) use ($endDateTime) {
                $q->where('started_at', '<=', $endDateTime);
            });
        }

        // Time-only filters (when no date is specified)
        if (empty($this->filterStartDate) && empty($this->filterEndDate)) {
            if (!empty($this->filterStartTime)) {
                $query->whereHas('session', function ($q) {
                    $q->whereTime('started_at', '>=', $this->filterStartTime);
                });
            }
            if (!empty($this->filterEndTime)) {
                $query->whereHas('session', function ($q) {
                    $q->whereTime('started_at', '<=', $this->filterEndTime);
                });
            }
        }

        // Get all filtered orders
        $allFilteredOrders = $query->get();

        // Group by cafeteria item and calculate statistics
        $groupedItems = $allFilteredOrders->groupBy('cafeteria_item_id')->map(function ($orders, $itemId) {
            $firstOrder = $orders->first();
            $totalQuantity = $orders->sum('units_count');
            $totalRevenue = $orders->sum('total_price');
            $totalOrders = $orders->count();
            $avgPricePerUnit = $orders->avg('price_per_unit');
            $lastOrderDate = $orders->max('created_at');
            $firstOrderDate = $orders->min('created_at');

            return (object) [
                'cafeteria_item_id' => $itemId,
                'item_name' => $firstOrder->cafeteriaItem->name,
                'total_quantity' => $totalQuantity,
                'total_revenue' => $totalRevenue,
                'total_orders' => $totalOrders,
                'avg_price_per_unit' => $avgPricePerUnit,
                'last_order_date' => $lastOrderDate,
                'first_order_date' => $firstOrderDate,
                'cafeteriaItem' => $firstOrder->cafeteriaItem,
                'orders' => $orders // Keep individual orders for detailed view if needed
            ];
        });

        // Apply quantity filters after grouping (since we need calculated total_quantity)
        if (!empty($this->filterMinQuantity)) {
            $groupedItems = $groupedItems->filter(function ($item) {
                return $item->total_quantity >= $this->filterMinQuantity;
            });
        }

        if (!empty($this->filterMaxQuantity)) {
            $groupedItems = $groupedItems->filter(function ($item) {
                return $item->total_quantity <= $this->filterMaxQuantity;
            });
        }

        // Apply sorting to grouped items
        if ($this->sortField === 'item_name') {
            $groupedItems = $this->sortDirection === 'asc' 
                ? $groupedItems->sortBy('item_name') 
                : $groupedItems->sortByDesc('item_name');
        } elseif ($this->sortField === 'total_quantity') {
            $groupedItems = $this->sortDirection === 'desc' 
                ? $groupedItems->sortByDesc('total_quantity') 
                : $groupedItems->sortBy('total_quantity');
        } elseif ($this->sortField === 'total_revenue') {
            $groupedItems = $this->sortDirection === 'desc' 
                ? $groupedItems->sortByDesc('total_revenue') 
                : $groupedItems->sortBy('total_revenue');
        } elseif ($this->sortField === 'total_orders') {
            $groupedItems = $this->sortDirection === 'desc' 
                ? $groupedItems->sortByDesc('total_orders') 
                : $groupedItems->sortBy('total_orders');
        } else {
            // Default sort by total quantity
            $groupedItems = $groupedItems->sortByDesc('total_quantity');
        }

        // Convert to collection and paginate manually
        $groupedItemsCollection = $groupedItems->values();
        
        // Use Livewire's built-in pagination
        $currentPage = $this->getPage();
        $perPage = $this->perPage;
        $offset = ($currentPage - 1) * $perPage;
        
        $paginatedItems = $groupedItemsCollection->slice($offset, $perPage);
        
        // Create paginator that works with Livewire
        $finalOrders = new \Illuminate\Pagination\LengthAwarePaginator(
            $paginatedItems->values(), // Reset keys
            $groupedItemsCollection->count(),
            $perPage,
            $currentPage,
            [
                'path' => request()->url(),
                'pageName' => 'page',
            ]
        );
        
        // Ensure query parameters are preserved
        $finalOrders->withQueryString();

        // Calculate summary statistics
        $stats = [
            'total_orders' => $allFilteredOrders->count(),
            'total_quantity' => $allFilteredOrders->sum('units_count'),
            'total_revenue' => $allFilteredOrders->sum('total_price'),
            'unique_items' => $groupedItemsCollection->count(),
        ];

        // Get available cafeteria items for filter dropdown
        $cafeteriaItems = CafeteriaItem::where('status', 1)->orderBy('name')->get();

        return view('livewire.cafeteria-overview', compact('finalOrders', 'stats', 'cafeteriaItems'));
    }

    public function sortBy($field, $direction = 'desc')
    {
        $this->sortField = $field;
        $this->sortDirection = $direction;
        $this->resetPage();
    }

    public function gotoPage($page)
    {
        $this->setPage($page);
    }
}