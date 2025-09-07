<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    @foreach ($items as $item)
        <div class="relative border p-2 rounded flex flex-col gap-1 shadow-sm bg-white">

            <!-- Top-right floating indicator -->
            @php
                $amount = $this->getAmount($item['id']) ?? 0;
                @endphp
            @if($amount > 0)
            <div class="absolute top-2 right-2 text-xs text-gray-600 bg-gray-100 px-2 py-0.5 rounded shadow-sm">

                Already added: {{$amount}}
            </div>
            @endif
            <div class="font-semibold truncate text-sm">{{ $item['name'] }}</div>

            <div class="flex items-center gap-1">
                <button
                    wire:click.prevent="decrementQuantity({{ $item['id'] }})"
                    class="px-2 py-0.5 bg-gray-300 rounded hover:bg-gray-400 text-sm"
                    type="button"
                >-</button>

                <input
                    type="text"
                    readonly
                    value="{{ $addItemData[$item['id']]['quantity'] ?? 1 }}"
                    class="w-12 text-center border rounded px-2 py-0.5 text-sm"
                />

                <div class="relative">
                    <button
                        wire:click.prevent="incrementQuantity({{ $item['id'] }})"
                        class="px-2 py-0.5 bg-gray-300 rounded hover:bg-gray-400 text-sm"
                        type="button"
                    >+</button>
                </div>
            </div>

            <input
                type="text"
                wire:model.defer="addItemData.{{ $item['id'] }}.notes"
                placeholder="notes (optional)"
                class="min-w-full border rounded px-2 py-1 text-xs"
            />

            <input
                type="text"
                wire:model.defer="addItemData.{{ $item['id'] }}.brand"
                placeholder="Brand (optional)"
                class="w-full border rounded px-2 py-1 text-xs"
            />

            <button
                wire:click="addItemToList({{ $item['id'] }})"
                class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700 text-sm self-start inline-block"
                type="button"
            >
                Add
            </button>
        </div>
    @endforeach
</div>


