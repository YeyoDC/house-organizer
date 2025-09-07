<div class="max-w-lg mx-auto py-6 px-4 space-y-6">

    <!-- Header -->
    <h2 class="text-3xl font-bold text-gray-800 flex items-center gap-2">
        🛒 <span>Shopping List</span>
    </h2>

    <!-- Sticky Total Price -->
    <div class="sticky top-0 z-40 bg-white border-b border-gray-200 px-4 py-3 text-lg font-semibold text-gray-800 flex justify-between items-center shadow-sm">
        <span>Total:</span>
        <span class="text-green-600">${{ number_format($totalShopping, 2) }} </span>
    </div>

    <!-- Item Cards -->
    @foreach ($listItems as $index => $item)
        <div wire:key="item-{{ $item->id }}"
             class="rounded-xl p-4 border shadow-sm transition hover:shadow-md space-y-2 {{ $item->purchased ? 'bg-gray-100 opacity-70' : 'bg-white' }}">
            <!-- Row 1: Item Name -->
            <div class="flex items-center gap-2">
                <input type="checkbox"
                       class="w-5 h-5 text-green-600 border-gray-300 rounded focus:ring-0"
                       wire:model="statuses.{{ $item->id }}"
                    @checked($item->purchased)
                    @disabled($item->purchased)>
                <span class="{{ $item->purchased ? 'line-through text-gray-500' : 'text-gray-900 font-medium' }} break-words">
                        {{ $item->groceryItem->name ?? 'Unnamed Item' }}

                    @if(!empty($item->brand))
                        <span class="bg-yellow-100 text-yellow-800 text-xs font-semibold ml-2 px-2 py-0.5 rounded">
                        {{ $item->brand }}
                        </span>
                    @endif
                </span>
            </div>

            <!-- Row 2: Quantity + Price Controls -->
            <div class="flex flex-wrap items-center justify-between gap-4 sm:gap-6">

                <!-- Quantity Controls -->
                <div class="flex items-center gap-2">
                    <button wire:click="decreaseQty({{ $index }})"
                            class="w-8 h-8 rounded-full bg-gray-200 text-xl text-gray-700 hover:bg-gray-300"
                    @disabled($item->purchased)">−</button>
                    <span class="w-6 text-center">{{ $quantities[$index] }}</span>
                    <button wire:click="increaseQty({{ $index }})"
                            class="w-8 h-8 rounded-full bg-gray-200 text-xl text-gray-700 hover:bg-gray-300"
                    @disabled($item->purchased)">+</button>
                </div>

                <!-- Price Input -->
                <div class="flex items-center gap-2 flex-shrink-0">
                    <label for="individual-price-{{ $index }}" class="text-gray-900 font-medium whitespace-nowrap">$</label>
                    <input type="number"
                           wire:change="updatePrice({{ $index }}, $event.target.value)"
                           placeholder="0.00"
                           @if($unitPrices[$index] == 0)
                               value=""
                           @else
                               value="{{ $unitPrices[$index] }}"
                           @endif
                           class="w-20 px-2 py-1 rounded border border-gray-300 text-gray-800 text-sm text-right focus:outline-none focus:ring-1 focus:ring-green-500"
                        @disabled($item->purchased)>
                </div>
            </div>

            <!-- Notes -->
            @if ($item->notes)
                <div class="text-sm text-gray-600 pl-6">
                    📝 {{ $item->notes }}
                </div>
            @endif

            <!-- Purchaser Info -->
            @if ($item->purchased && $item->purchasedByUser)
                <div class="text-sm text-gray-500 pl-6">
                    ✅ Purchased by: {{ $item->purchasedByUser->name }}
                </div>
            @endif
        </div>
    @endforeach

    <!-- Finalize Footer -->
    <div class="fixed bottom-0 left-0 right-0 z-50 bg-white border-t px-4 py-3 shadow-lg flex justify-between max-w-lg mx-auto">
        <a href="{{ route('groceries.index') }}"
           class="px-4 py-2 text-gray-600 border border-gray-300 rounded-md hover:bg-gray-100 w-1/2 text-center mr-2">
            Cancel
        </a>

        <button wire:click="finalizeShopping"
                class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 w-1/2 text-center font-semibold">
            Finalize
        </button>
    </div>
</div>


