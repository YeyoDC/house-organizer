<div class="max-w-lg mx-auto py-4 px-2 space-y-4">

    <h2 class="text-2xl font-semibold mb-4 text-gray-800">🛒 Shopping List</h2>

    @foreach ($listItems as $index => $item)
        @php
            $purchased = $item['purchased'] ?? false;
            $itemName = $item['grocery_item']['name'] ?? 'Unnamed Item';
            $qty = $item['quantity'] ?? 1;
            $note = $item['notes'] ?? null;
        @endphp

        <div wire:key="item-{{ $item['id'] }}"
             class="rounded-xl p-4 shadow-sm border bg-white space-y-2">

            <!-- Row 1: Checkmark, Name, Quantity Controls -->
            <div class="flex justify-between items-center">
                <label class="flex items-center gap-3 cursor-pointer text-base">
                    <input type="checkbox" wire:model="listItems.{{ $index }}.purchased"
                           class="w-5 h-5 rounded border-gray-300 text-green-600 focus:ring-0">
                    <span class="{{ $purchased ? 'line-through text-gray-500' : 'text-gray-900 font-medium' }}">
                        {{ $itemName }}
                    </span>
                </label>

                <!-- Quantity buttons -->
                <div class="flex items-center gap-2">
                    <button wire:click="decreaseQty({{ $index }})"
                            class="w-8 h-8 rounded-full bg-gray-200 text-xl leading-6 text-gray-700 hover:bg-gray-300">−</button>
                    <span class="w-6 text-center">{{ $qty }}</span>
                    <button wire:click="increaseQty({{ $index }})"
                            class="w-8 h-8 rounded-full bg-gray-200 text-xl leading-6 text-gray-700 hover:bg-gray-300">+</button>
                </div>
            </div>

            <!-- Notes -->
            @if ($note)
                <div class="text-sm text-gray-600 pl-8">
                    📝 {{ $note }}
                </div>
            @endif

            <!-- Expiry Date -->
        </div>
    @endforeach

    <!-- Action Buttons -->
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


