@php
    $groupedByCategory = $stock->groupBy(fn($item) => $item->groceryItem->category->name ?? 'Uncategorized');
@endphp

<div
    x-data="{ openCategory: null }"
    @click.outside="openCategory = null"
    class="grid grid-cols-2 gap-3 sm:grid-cols-2"
>
    @foreach ($groupedByCategory as $categoryName => $items)
        @php
            $icon = $items->first()->groceryItem->category->icon ?? '📦';
            $color = $categoryColors[$categoryName] ?? 'bg-gray-100';
            $key = \Str::slug($categoryName);
        @endphp

        <template x-if="!openCategory || openCategory === '{{ $key }}'">
            <div
                :class="openCategory === '{{ $key }}' ? 'col-span-2' : ''"
                class="transition-all duration-300 rounded-xl shadow-sm {{ $color }} relative"
            >
                {{-- Header / Clickable Card --}}
                <div
                    class="p-4 cursor-pointer flex flex-col justify-between"
                    @click="openCategory === '{{ $key }}' ? openCategory = null : openCategory = '{{ $key }}'"
                >
                    <div class="flex justify-between items-center">
                        <div class="flex items-center gap-2 font-semibold">
                            <span class="text-xl">{{ $icon }}</span>
                            <span class="truncate text-sm">{{ $categoryName }}</span>
                        </div>
                        <div class="text-xl text-gray-600">
                            <template x-if="openCategory !== '{{ $key }}'">+</template>
                            <template x-if="openCategory === '{{ $key }}'">−</template>
                        </div>
                    </div>

                    <div class="text-sm mt-3 text-gray-600">
                        {{ $items->count() }} item{{ $items->count() > 1 ? 's' : '' }}
                    </div>
                </div>

                {{-- Expanded Content --}}
                <div
                    x-show="openCategory === '{{ $key }}'"
                    x-collapse
                    class="px-4 pb-4 space-y-2"
                >
                    @foreach ($items as $item)
                        @include('livewire.groceries._stock-item', ['item' => $item])
                    @endforeach

                    <button class="mt-3 text-xs text-indigo-700 hover:underline">+ Add to {{ $categoryName }}</button>
                    <button
                        class="block mt-1 text-xs text-gray-500 hover:underline"
                        @click.stop="openCategory = null"
                    >
                        Collapse
                    </button>
                </div>
            </div>
        </template>
    @endforeach
</div>
