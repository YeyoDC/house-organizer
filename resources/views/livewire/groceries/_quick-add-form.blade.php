<div x-data="{ showAddForm: false }" class="mt-3">
    <!-- Toggle Button -->
    <button
        @click="showAddForm = !showAddForm"
        class="text-sm text-green-700 bg-green-100 hover:bg-green-200 px-3 py-1 rounded"
    >
        + Add Item
    </button>

    <!-- Quick Add Form -->
    <div
        x-show="showAddForm"
        x-transition
        class="mt-2 bg-white border rounded-lg shadow p-3"
    >
        <input
            type="text"
            wire:model.defer="itemName"
            placeholder="Item name"
            class="border rounded w-full px-2 py-1 text-sm mb-2"
        />

        <div class="flex justify-between items-center">
            <button
                wire:click="addNewItemToCategory('{{ $items[0]['category_id'] }}')"
                class="bg-green-600 hover:bg-green-700 text-white text-sm px-3 py-1 rounded"
                type="button"
            >
                Save
            </button>
            <button
                @click="showAddForm = false"
                class="text-sm text-gray-500 hover:underline"
            >
                Cancel
            </button>
        </div>
    </div>
</div>
