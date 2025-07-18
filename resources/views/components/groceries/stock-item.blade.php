@props(['item'])

@php
    $isExpired = $item->expiry_date && \Carbon\Carbon::parse($item->expiry_date)->isPast();
    $expiryText = $item->expiry_date
        ? 'Expires: ' . \Carbon\Carbon::parse($item->expiry_date)->format('M d')
        : null;
@endphp

<div class="p-3 rounded-lg bg-lime-100 border border-gray-200 shadow-sm">
    {{-- Row 1: Name and brand --}}
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

    {{-- Row 2: Quantity, expiry, buttons --}}
    <div class="flex justify-between items-center text-xs mt-1 flex-wrap gap-2">
        {{-- Quantity --}}
        <div class="font-mono text-gray-800">
            Qty: {{ $item->quantity }}
        </div>

        {{-- Expiry date --}}
        @if ($expiryText)
            <div class="{{ $isExpired ? 'text-red-500' : 'text-gray-500' }}">
                {{ $expiryText }}
            </div>
        @endif

        {{-- Buttons --}}
        <div class="flex gap-1 ml-auto">
            <button class="px-2 py-1 rounded bg-gray-200 hover:bg-gray-300 text-xs">−</button>
            <button class="px-2 py-1 rounded bg-gray-200 hover:bg-gray-300 text-xs">+</button>
        </div>
    </div>
</div>
