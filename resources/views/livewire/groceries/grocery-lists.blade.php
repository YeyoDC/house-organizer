<div class="bg-white p-4 rounded shadow" x-data="{ showModal: false, openList: true }" @list-created.window="showModal = false">
    <div class="flex justify-between items-center mb-2">
        <h3 class="text-lg font-semibold">
            {{ $viewMode === 'household' ? 'Household Grocery List' : 'My Grocery List' }}
        </h3>

        <div class="flex items-center gap-2">
            <button
                @click="showModal = true"
                class="px-3 py-1 text-sm bg-indigo-600 text-white rounded hover:bg-indigo-700"
            >
                + Create New List
            </button>
            <button
                @click="openList = !openList"
                class="text-sm text-indigo-600 hover:underline"
            >
                <span x-show="openList">Minimize</span>
                <span x-show="!openList">Show</span>
            </button>
        </div>
    </div>

    <div x-show="openList" x-collapse>
        {{-- Modal --}}
        <x-groceries.create-list-modal />

        {{-- Grocery List Display --}}
        <div x-data="{ openListId: null }" class="space-y-4 mt-4">
            @forelse ($groceryLists as $list)
                @php
                    $listKey = 'list-' . $list->id;
                @endphp
                <div class="rounded-lg border shadow-sm p-4 bg-gray-50 transition-all duration-300">
                    <div
                        @click="openListId === '{{ $listKey }}' ? openListId = null : openListId = '{{ $listKey }}'"
                        class="flex items-center justify-between gap-2 cursor-pointer flex-wrap"
                    >
                        {{-- Left side: Name, Due Date, Status --}}
                        <div class="flex flex-wrap items-center gap-2 text-sm">
            <span class="font-semibold truncate max-w-[120px] sm:max-w-xs">
                {{ $list->name ?: 'Untitled List' }}
            </span>

                            <span class="text-gray-500 whitespace-nowrap">
                📅 {{ $list->due_date ? \Carbon\Carbon::parse($list->due_date)->format('M d, Y') : 'No due date' }}
            </span>

                            <span class="text-gray-600 capitalize">
                • {{ $list->status }}
            </span>
                        </div>

                        {{-- Right side: Expand/collapse toggle --}}
                        <div class="text-gray-500 text-lg ml-auto">
                            <template x-if="openListId !== '{{ $listKey }}'">+</template>
                            <template x-if="openListId === '{{ $listKey }}'">−</template>
                        </div>
                    </div>

                    {{-- Expanded contents --}}
                    <div
                        x-show="openListId === '{{ $listKey }}'"
                        x-collapse
                        class="mt-3"
                    >
                        <livewire:groceries.grocery-list-items :groceryListId="$list->id" />
                    </div>
                </div>


            @empty
                <p class="text-sm text-gray-500">No grocery lists yet.</p>
            @endforelse
        </div>
    </div>
</div>
