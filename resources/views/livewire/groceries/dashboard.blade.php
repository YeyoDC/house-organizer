<div class="space-y-6">

    {{-- Header + View Toggle --}}
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2">
        <h2 class="text-xl font-semibold">
            {{ $viewMode === 'household' ? 'Household Grocery Stock' : 'My Grocery Stock' }}
        </h2>

        <div class="flex gap-2">
            <button wire:click="switchView('personal')" class="px-3 py-1 text-sm bg-gray-200 rounded hover:bg-gray-300">
                Personal
            </button>
            <button wire:click="switchView('household')" class="px-3 py-1 text-sm bg-gray-200 rounded hover:bg-gray-300">
                Household
            </button>
        </div>
    </div>

    {{-- Grocery Stock Section --}}
    <div class="bg-white p-4 rounded shadow">
        <div class="flex justify-between items-center mb-2">
            <h3 class="text-lg font-semibold">Grocery Stock</h3>
            <button
                @click="openStock = !openStock"
                class="text-sm text-indigo-600 hover:underline"
            >
                <span x-show="openStock">Minimize</span>
                <span x-show="!openStock">Show</span>
            </button>
        </div>

        <div x-show="openStock" x-collapse>
            <livewire:groceries.grocery-stock :viewMode="$viewMode" />
        </div>
    </div>

    {{-- Grocery List Section --}}
    <livewire:groceries.grocery-lists :viewMode="$viewMode" />


</div>

