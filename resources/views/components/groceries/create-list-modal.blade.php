<div x-show="showModal" x-cloak class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
    <div @click.away="showModal = false" class="bg-white rounded-lg p-6 w-full max-w-md shadow-lg space-y-4">
        <h2 class="text-lg font-semibold">Create Grocery List</h2>

        <div class="space-y-2">
            <label class="block text-sm font-medium">Name (optional)</label>
            <input type="text" wire:model.defer="newList.name" class="w-full border rounded px-3 py-2">

            <label class="block text-sm font-medium">Due Date</label>
            <input type="date" wire:model.defer="newList.due_date" class="w-full border rounded px-3 py-2">

            <label class="block text-sm font-medium">List Type</label>
            <select wire:model.defer="newList.scope" class="w-full border rounded px-3 py-2">
                <option value="personal">Personal</option>
                <option value="household">Household</option>
            </select>
        </div>

        <div class="flex justify-end gap-2 pt-4">
            <button @click="showModal = false" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Cancel</button>
            <button wire:click="createList" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Create</button>
        </div>
    </div>
</div>
