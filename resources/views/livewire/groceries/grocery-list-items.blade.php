<div class="space-y-4">

    {{-- Items in the Grocery List --}}
    <div>
        <h4 class="font-semibold mb-2">Items in this list:</h4>

        @if($listItems->isEmpty())
            <p class="text-gray-500 italic">No items added yet.</p>
        @else
            <ul class="divide-y divide-gray-200 rounded border overflow-hidden bg-white shadow-sm">
                @foreach ($listItems as $listItem)
                    @php
                        $item = $listItem->groceryItem;
                        $categoryName = $item->category->name ?? 'Uncategorized';
                        $color = $categoryColors[$categoryName] ?? 'bg-gray-50';
                    @endphp

                    <li
                        x-data="{ showNotes: false }"
                        class="p-3 {{ $color }}"
                    >
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                            {{-- Name and quantity grouped --}}
                            <div class="flex items-center gap-3">
                                <span class="font-semibold text-sm truncate max-w-[150px]">
                                    {{ $item->name }}
                                </span>
                                <span class="text-sm text-gray-700 flex-shrink-0">
                                    x{{ $listItem->quantity }}
                                </span>

                                {{-- Expand notes button, only if notes exist --}}
                                @if ($listItem->notes)
                                    <button
                                        @click="showNotes = !showNotes"
                                        class="ml-2 text-indigo-600 hover:text-indigo-800 text-xs font-medium focus:outline-none"
                                        :aria-expanded="showNotes.toString()"
                                        aria-controls="notes-{{ $listItem->id }}"
                                        aria-label="Toggle notes visibility"
                                    >
                                        <span x-text="showNotes ? 'Hide notes' : 'Show notes'"></span>
                                    </button>
                                @endif
                            </div>

                            {{-- Brand on right for desktop --}}
                            @if ($item->brand)
                                <div class="text-sm text-gray-500 not-italic italic sm:italic">
                                    Brand: <span class="font-medium">{{ $item->brand }}</span>
                                </div>
                            @endif
                        </div>

                        {{-- Expandable notes below --}}
                        <div
                            x-show="showNotes"
                            x-transition
                            id="notes-{{ $listItem->id }}"
                            class="mt-1 text-sm text-gray-500 italic max-w-md"
                        >
                            “{{ $listItem->notes }}”
                        </div>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

    {{-- Add new items button --}}
    <a
        href="{{ route('listItems.create', [$groceryListId]) }}"
        class="mt-4 px-3 py-1 bg-indigo-600 text-white rounded hover:bg-indigo-700 inline-block"
    >
        Add Items
    </a>
    @if(!$listItems->isEmpty())
    <a
        href="{{route('listItems.edit', [$groceryListId])}}"
        class="mt-4 px-3 py-1 bg-indigo-600 text-white rounded hover:bg-indigo-700 inline-block"
    >
        Start Shopping
    </a>
    @endif

</div>

