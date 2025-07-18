<div class="p-3 rounded-lg bg-lime-100 border border-gray-200 shadow-sm">
    <div class="flex justify-between items-center mb-1">
        <div class="font-semibold text-sm truncate">
            {{ $item->groceryItem->name }}
        </div>
        @if ($item->brand)
            <div class="text-xs text-gray-400 truncate">
                {{ $item->brand }}
            </div>
        @endif
    </div>

    <div class="flex justify-between items-center text-xs mt-1 flex-wrap gap-2">
        <div class="font-mono text-gray-800">
            Qty: {{ $item->quantity }}
        </div>

        @if ($item->expiry_date)
            <div class="{{ \Carbon\Carbon::parse($item->expiry_date)->isPast() ? 'text-red-500' : 'text-gray-500' }}">
                Expires: {{ \Carbon\Carbon::parse($item->expiry_date)->format('M d') }}
            </div>
        @endif

        <div class="flex gap-1 ml-auto">
            <button wire:click="decrementQuantity({{ $item->id }})" class="px-2 py-1 rounded bg-gray-200 hover:bg-gray-300 text-xs">−</button>
            <button wire:click="incrementQuantity({{ $item->id }})" class="px-2 py-1 rounded bg-gray-200 hover:bg-gray-300 text-xs">+</button>
            <button wire:click="removeItem({{ $item->id }})" class="text-xs text-red-500 hover:underline">Remove</button>
        </div>
    </div>
</div>

