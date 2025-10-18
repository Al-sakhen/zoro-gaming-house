<div class="space-y-4">
    <div class="flex justify-between items-center">
        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Create Order</h3>
        <button wire:click="$dispatch('closeDialog')" 
                class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>

    <!-- Flash Messages -->
    @if (session()->has('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
            {{ session('error') }}
        </div>
    @endif

    <!-- Session Summary -->
    <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg">
        <h4 class="font-medium text-blue-900 dark:text-blue-100 mb-2">Session Summary</h4>
        <div class="space-y-1 text-sm text-blue-800 dark:text-blue-200">
            <p><span class="font-medium">Room:</span> {{ $session->room->name }}</p>
            <p><span class="font-medium">Duration:</span> {{ $this->getDurationDisplay() }}</p>
            <p><span class="font-medium">Started:</span> {{ $session->started_at->format('H:i') }}</p>
            <p><span class="font-medium">Ended:</span> {{ $session->ended_at->format('H:i') }}</p>
            <p><span class="font-medium">Billed Hours:</span> {{ $session->getDurationInHours() }}</p>
        </div>
    </div>

    <!-- Order Form -->
    <form wire:submit="createOrder" class="space-y-4">
        <!-- Gaming Price (Read-only) -->
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Gaming Price</label>
            <div class="w-full px-3 py-2 bg-gray-100 dark:bg-gray-600 border border-gray-300 dark:border-gray-500 rounded-md text-gray-900 dark:text-white font-medium">
                {{ number_format($gaming_price, 2) }} JD
            </div>
        </div>

        <!-- Additional Items -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Drinks</label>
                <input type="number" step="0.01" min="0" wire:model.live="drinks_price" 
                       placeholder="0.00"
                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                @error('drinks_price') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Shisha</label>
                <input type="number" step="0.01" min="0" wire:model.live="shisha_price" 
                       placeholder="0.00"
                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                @error('shisha_price') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Coffee</label>
                <input type="number" step="0.01" min="0" wire:model.live="coffee_price" 
                       placeholder="0.00"
                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                @error('coffee_price') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
        </div>

        <!-- Discount -->
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Discount Amount</label>
            <input type="number" step="0.01" min="0" wire:model.live="discount_amount" 
                   placeholder="0.00"
                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
            @error('discount_amount') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <!-- Total Calculation -->
        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg space-y-2">
            <div class="flex justify-between text-sm">
                <span class="text-gray-600 dark:text-gray-300">Gaming:</span>
                <span class="text-gray-900 dark:text-white">{{ number_format($gaming_price, 2) }} JD</span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-gray-600 dark:text-gray-300">Drinks:</span>
                <span class="text-gray-900 dark:text-white">{{ number_format($drinks_price, 2) }} JD</span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-gray-600 dark:text-gray-300">Shisha:</span>
                <span class="text-gray-900 dark:text-white">{{ number_format($shisha_price, 2) }} JD</span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-gray-600 dark:text-gray-300">Coffee:</span>
                <span class="text-gray-900 dark:text-white">{{ number_format($coffee_price, 2) }} JD</span>
            </div>
            @if($discount_amount > 0)
                <div class="flex justify-between text-sm">
                    <span class="text-red-600 dark:text-red-400">Discount:</span>
                    <span class="text-red-600 dark:text-red-400">-{{ number_format($discount_amount, 2) }} JD</span>
                </div>
            @endif
            <hr class="border-gray-300 dark:border-gray-600">
            <div class="flex justify-between text-lg font-bold">
                <span class="text-gray-900 dark:text-white">Total:</span>
                <span class="text-green-600 dark:text-green-400">{{ number_format($total_amount, 2) }} JD</span>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-end space-x-3 pt-4">
            <button type="button" wire:click="$dispatch('closeDialog')" 
                    class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition-colors">
                Cancel
            </button>
            <button type="submit" 
                    wire:loading.attr="disabled"
                    wire:target="createOrder"
                    class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors disabled:opacity-50">
                <span wire:loading.remove wire:target="createOrder">Create Order</span>
                <span wire:loading wire:target="createOrder">Creating...</span>
            </button>
        </div>
    </form>
</div>
