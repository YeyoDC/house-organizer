@php
    $groupedByCategory = $groupedItems;
    $chunkedCategories = collect($groupedByCategory)->chunk(9); // 3x3 mobile chunks
@endphp

<div class="relative pb-24"> {{-- ✅ SINGLE ROOT ELEMENT --}}

    <div
        x-data="{
            openCategory: null,
            toggleCategory(key) {
                this.openCategory = this.openCategory === key ? null : key;
            }
        }"
        @click.outside="openCategory = null"
    >

        {{-- 📱 Mobile: Scrollable 3x3 chunks --}}
        <div class="sm:hidden" x-show="openCategory === null" x-transition>
            <div class="flex overflow-x-auto gap-4 px-2 pb-4 snap-x scroll-smooth">
                @foreach ($chunkedCategories as $chunk)
                    <div class="grid grid-cols-3 gap-3 min-w-full snap-start">
                        @foreach ($chunk as $categoryName => $items)
                            @php
                                $key = \Str::slug($categoryName);
                                $icon = $items[0]['icon'] ?? '🧺';
                                $color = $categoryColors[$categoryName] ?? 'bg-gray-100';
                            @endphp

                            <div
                                class="rounded-lg shadow text-center {{ $color }} p-3 cursor-pointer"
                                @click="toggleCategory('{{ $key }}')"
                            >
                                <div class="flex flex-col items-center justify-center gap-1">
                                    <div class="text-2xl">{{ $icon }}</div>
                                    <div class="text-[11px] font-semibold leading-tight break-words text-center">
                                        {{ $categoryName }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        @for ($i = $chunk->count(); $i < 9; $i++)
                            <div class="invisible p-3"></div>
                        @endfor
                    </div>
                @endforeach
            </div>
        </div>

        {{-- 🖥️ Desktop: Standard grid --}}
        <div class="hidden sm:grid grid-cols-2 sm:grid-cols-3 gap-4 mt-4" x-show="openCategory === null" x-transition>
            @foreach ($groupedByCategory as $categoryName => $items)
                @php
                    $key = \Str::slug($categoryName);
                    $icon = $items[0]['icon'] ?? '🧺';
                    $color = $categoryColors[$categoryName] ?? 'bg-gray-100';
                @endphp

                <div
                    class="transition-all duration-300 rounded-xl shadow-sm {{ $color }} cursor-pointer"
                    @click="toggleCategory('{{ $key }}')"
                >
                    <div class="p-4">
                        <div class="flex flex-col items-center text-center gap-1">
                            <span class="text-2xl">{{ $icon }}</span>
                            <span class="font-semibold text-xs leading-tight break-words max-w-full">
                                {{ $categoryName }}
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- 🔽 Expanded Category --}}
        @foreach ($groupedByCategory as $categoryName => $items)
            @php $key = \Str::slug($categoryName); @endphp

            <div
                x-show="openCategory === '{{ $key }}'"
                x-collapse
                class="mt-4 px-2 sm:px-0 space-y-2"
            >
                <div class="rounded-xl shadow-sm p-4 {{ $categoryColors[$categoryName] ?? 'bg-white' }}">
                    <div class="flex justify-between items-center mb-3">
                        <div class="flex items-center gap-2 font-semibold text-lg">
                            <span>{{ $items[0]['icon'] ?? '🧺' }}</span>
                            <span>{{ $categoryName }}</span>
                        </div>
                        <button
                            class="text-sm text-gray-600 hover:underline"
                            @click="openCategory = null"
                        >
                            Close
                        </button>
                    </div>

                    @include('livewire.groceries._category-items', ['items' => $items])
                    @include('livewire.groceries._quick-add-form')
                </div>
            </div>
        @endforeach
    </div>

    {{-- 📋 Current Grocery List Items --}}
    <div class="mt-6 mb-28 px-2 sm:px-0">
        <h3 class="text-lg font-semibold text-gray-800 mb-3">🛒 Items Already in This List</h3>

        @if (isset($currentListItems) && count($currentListItems))
            <div class="bg-white rounded-xl shadow-sm p-3 divide-y divide-gray-200">
                @foreach ($currentListItems as $item)
                    <div
                        x-data="{ showNotes: false }"
                        class="py-2"
                    >
                        {{-- Main row with all info --}}
                        <div class="flex justify-between items-center gap-4">
                            {{-- Item name and brand --}}
                            <div class="flex items-center gap-2 flex-1 min-w-0">
                            <span class="font-medium text-gray-900">
                                {{ $item['grocery_item']['name'] ?? 'Unnamed' }}
                            </span>

                                {{-- Brand Display --}}
                                @if (!empty($item['brand']))
                                    <span class="text-xs text-blue-600 font-medium">
                                    ({{ $item['brand'] }})
                                </span>
                                @endif

                                {{-- Notes indicator --}}
                                @if (!empty($item['notes']))
                                    <button
                                        @click="showNotes = !showNotes"
                                        class="text-indigo-600 hover:text-indigo-800 text-xs"
                                        title="{{ $item['notes'] }}"
                                    >
                                        📝notes
                                    </button>
                                @endif
                            </div>

                            {{-- Quantity controls --}}
                            <div class="flex items-center gap-1">
                                <button
                                    wire:click="decrementItemQuantity({{ $item['id'] }})"
                                    class="px-2 py-0.5 bg-gray-300 rounded hover:bg-gray-400 text-sm"
                                    type="button"
                                >-</button>

                                <span class="w-10 text-center text-sm font-medium">
                                {{ $item['quantity'] }}
                            </span>

                                <button
                                    wire:click="incrementItemQuantity({{ $item['id'] }})"
                                    class="px-2 py-0.5 bg-gray-300 rounded hover:bg-gray-400 text-sm"
                                    type="button"
                                >+</button>
                            </div>

                            {{-- Remove button --}}
                            <button
                                wire:click="removeItemFromList({{ $item['id'] }})"
                                class="text-red-600 hover:text-red-800 flex-shrink-0"
                                title="Remove item"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-4h4m-4 0a1 1 0 00-1 1v1h6V4a1 1 0 00-1-1m-4 0h4" />
                                </svg>
                            </button>
                        </div>

                        {{-- Notes content, expands below --}}
                        @if (!empty($item['notes']))
                            <div
                                x-show="showNotes"
                                x-transition
                                id="notes-{{ $item['id'] }}"
                                class="mt-2 text-xs text-gray-500 italic bg-gray-50 p-2 rounded"
                            >
                                📝  {{ $item['notes'] }}
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-sm text-gray-600 italic">No items added yet.</p>
        @endif
    </div>



    {{-- 📱 Fixed Back Button --}}
    <div class="fixed bottom-0 left-0 right-0 z-50 bg-white border-t shadow-md">
        <div class="max-w-lg mx-auto px-4 py-3">
            <a href="{{ route('groceries.index') }}"
               class="block w-full text-center bg-gray-100 text-gray-800 font-semibold py-2 rounded-lg hover:bg-gray-200 transition">
                ← Back to List Overview
            </a>
        </div>
    </div>
</div>
