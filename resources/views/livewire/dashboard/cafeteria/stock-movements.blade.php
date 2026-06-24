<div>
    <div class="modal-body">
        @if (!$cafeteriaItemId)
            <div class="alert alert-info mb-0">
                Select an item to view stock movements.
            </div>
        @else
            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                <div>
                    <h6 class="mb-0">Item: {{ $itemName }}</h6>
                    <small class="text-muted">Showing {{ $movements->total() }} movement records</small>
                </div>
            </div>

            <div class="card mb-3 border-0 bg-light-subtle">
                <div class="card-body">
                    <div class="row g-2 align-items-end">
                        <div class="col-md-3">
                            <label class="form-label mb-1">Type</label>
                            <select class="form-select" wire:model.live="movementType">
                                <option value="">All types</option>
                                <option value="reserve">Reserve</option>
                                <option value="release">Release</option>
                                <option value="manual_in">Manual In</option>
                                <option value="manual_out">Manual Out</option>
                                <option value="manual_set">Manual Set</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label mb-1">Source</label>
                            <input type="text" class="form-control" wire:model.live.debounce.300ms="source"
                                placeholder="talabat, stock_control...">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label mb-1">Session ID</label>
                            <input type="number" min="1" class="form-control" wire:model.live="sessionId"
                                placeholder="e.g. 12">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label mb-1">From</label>
                            <input type="date" class="form-control" wire:model.live="dateFrom">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label mb-1">To</label>
                            <input type="date" class="form-control" wire:model.live="dateTo">
                        </div>
                    </div>
                    <div class="mt-2 d-flex justify-content-end">
                        <button type="button" class="btn btn-sm btn-secondary" wire:click="resetFilters">
                            Clear Filters
                        </button>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-sm table-striped align-middle">
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Change</th>
                            <th>Before</th>
                            <th>After</th>
                            <th>Session</th>
                            <th>Source</th>
                            <th>Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($movements as $movement)
                            <tr>
                                <td>
                                    @if ($movement->movement_type === 'reserve')
                                        <span class="badge bg-danger">Reserve</span>
                                    @elseif ($movement->movement_type === 'release')
                                        <span class="badge bg-success">Release</span>
                                    @elseif ($movement->movement_type === 'manual_in')
                                        <span class="badge bg-primary">Manual In</span>
                                    @elseif ($movement->movement_type === 'manual_out')
                                        <span class="badge bg-warning text-dark">Manual Out</span>
                                    @elseif ($movement->movement_type === 'manual_set')
                                        <span class="badge bg-secondary">Manual Set</span>
                                    @else
                                        <span class="badge bg-dark">{{ $movement->movement_type }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($movement->quantity_change > 0)
                                        +{{ $movement->quantity_change }}
                                    @else
                                        {{ $movement->quantity_change }}
                                    @endif
                                </td>
                                <td>{{ $movement->quantity_before ?? '-' }}</td>
                                <td>{{ $movement->quantity_after ?? '-' }}</td>
                                <td>
                                    @if ($movement->session_id)
                                        #{{ $movement->session_id }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ $movement->source ?? '-' }}</td>
                                <td>{{ optional($movement->created_at)->format('Y-m-d H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-3">
                                    No stock movements match the current filters for {{ $itemName }}.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap gap-2">
                <small class="text-muted">
                    Page {{ $movements->currentPage() }} of {{ $movements->lastPage() }}
                </small>
                <div>
                    {{ $movements->links() }}
                </div>
            </div>
        @endif
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    </div>
</div>
