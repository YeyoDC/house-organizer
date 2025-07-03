<div class="space-y-6">

    <!-- Single Entry Form -->
    <div class="border p-4 rounded shadow-md">
        <h2 class="text-lg font-semibold mb-4">Add a New Chore</h2>

        <!-- Recurrence Toggle -->
        <div class="mb-4">
            <label class="font-semibold">Is this a recurring task?</label>
            <div class="flex items-center space-x-4 mt-2">
                <label class="flex items-center space-x-1">
                    <input type="radio" wire:model="is_recurring" value="0" name="recurrent">
                    <span>One-time</span>
                </label>
                <label class="flex items-center space-x-1">
                    <input type="radio" wire:model="is_recurring" value="1" name="recurrent">
                    <span>Recurring</span>
                </label>
            </div>
        </div>
        <div x-data="{ actions: [] }"
             x-init="$watch('$wire.location_id', async (val) => {
        if (val) {
            const res = await $wire.getFilteredActions(val)
            actions = res;
        } else {
            actions = [];
        }
     })"
        >
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">

            <div>
                <label>Location</label>
                <select wire:model="location_id" class="w-full">
                    <option value="">Select</option>
                    @foreach($locations as $location)
                        <option value="{{ $location->id }}">{{ $location->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label>Action</label>
                <select wire:model="action_id" class="w-full" :disabled="!actions.length">
                    <option value="">Select</option>
                    <template x-for="action in actions" :key="action.id">
                        <option :value="action.id" x-text="action.name"></option>
                    </template>
                </select>
            </div>

            <!-- Recurring Fields -->
            <div x-show="$wire.is_recurring == 1" x-cloak>
                <label>Recurrence</label>
                <select wire:model="recurrence" class="w-full">
                    <option value="">Select</option>
                    <option value="daily">Daily</option>
                    <option value="weekly">Weekly</option>
                    <option value="bi-weekly">Bi-weekly</option>
                    <option value="monthly">Monthly</option>
                </select>
            </div>

            <div x-show="$wire.is_recurring == 1" x-cloak>
                <label>Start Date</label>
                <input type="date" wire:model="start_date" class="w-full" />
            </div>

            <div x-show="$wire.is_recurring == 1" x-cloak>
                <label>End Date (optional)</label>
                <input type="date" wire:model="end_date" class="w-full" />
            </div>

            <!-- One-time Fields -->
            <div x-show="$wire.is_recurring == 0" x-cloak>
                <label>Due Date</label>
                <input type="date" wire:model="due_date" class="w-full" />
            </div>
        </div>

        <div class="mb-4">
            <label>Notes</label>
            <textarea wire:model="notes" class="w-full"></textarea>
        </div>

        <button wire:click="addChore" class="bg-blue-600 text-white px-4 py-2 rounded">
            Add to List
        </button>
    </div>

    <!-- Chores Preview Table -->
    @if (count($chores))
        <div class="border p-4 rounded shadow-md">
            <h2 class="text-lg font-semibold mb-4">Chores to Be Created</h2>
            <table class="w-full text-sm border-collapse">
                <thead>
                <tr class="bg-gray-100">
                    <th class="px-2 py-1 text-left">Action</th>
                    <th class="px-2 py-1 text-left">Location</th>
                    <th class="px-2 py-1 text-left">Date</th>
                    <th class="px-2 py-1 text-left">Recurrence</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($chores as $i => $chore)
                    <tr>
                        <td class="px-2 py-1">{{ $actions->find($chore['action_id'])?->name }}</td>
                        <td class="px-2 py-1">{{ $locations->find($chore['location_id'])?->name }}</td>
                        <td class="px-2 py-1">
                            {{ $chore['start_date'] }}
                            @if(!empty($chore['end_date']) && $chore['end_date'] !== $chore['start_date'])
                                - {{ $chore['end_date'] }}
                            @endif
                        </td>
                        <td class="px-2 py-1">
                            {{ $chore['recurrence'] !== 'none' ? ucfirst($chore['recurrence']) : 'One-time' }}
                        </td>
                        <td class="px-2 py-1">
                            <button wire:click="removeChore({{ $i }})" class="text-red-500 text-xs hover:underline">
                                Remove
                            </button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <button wire:click="saveAll" class="mt-4 bg-green-600 text-white px-4 py-2 rounded">
                Save All Chores
            </button>
        </div>
    @endif

    @if (session()->has('message'))
        <div class="text-green-600 font-semibold mt-2">
            {{ session('message') }}
        </div>
    @endif
</div>



{{--<div class="space-y-6">--}}

{{--    <!-- Single Entry Form -->--}}
{{--    <div class="border p-4 rounded shadow-md" x-data>--}}
{{--        <h2 class="text-lg font-semibold mb-4">Add a New Chore</h2>--}}

{{--        <!-- Recurrence Toggle -->--}}
{{--        <div class="mb-4">--}}
{{--            <label class="font-semibold">Is this a recurring task?</label>--}}
{{--            <div class="flex items-center space-x-4 mt-2">--}}
{{--                <label class="flex items-center space-x-1">--}}
{{--                    <input type="radio" wire:model="is_recurring" value="0" name="recurrent">--}}
{{--                    <span>One-time</span>--}}
{{--                </label>--}}
{{--                <label class="flex items-center space-x-1">--}}
{{--                    <input type="radio" wire:model="is_recurring" value="1" name="recurrent">--}}
{{--                    <span>Recurring</span>--}}
{{--                </label>--}}
{{--            </div>--}}
{{--        </div>--}}

{{--        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">--}}


{{--            <div>--}}
{{--                <label>Location</label>--}}
{{--                <select wire:model="location_id" class="w-full">--}}
{{--                    <option value="">Select</option>--}}
{{--                    @foreach($locations as $location)--}}
{{--                        <option value="{{ $location->id }}">{{ $location->name }}</option>--}}
{{--                    @endforeach--}}
{{--                </select>--}}
{{--            </div>--}}
{{--            <div>--}}
{{--                <label>Action</label>--}}
{{--                <select wire:model="action_id" class="w-full">--}}
{{--                    <option value="">Select</option>--}}
{{--                    @foreach($actions as $action)--}}
{{--                        <option value="{{ $action->id }}">{{ $action->name }}</option>--}}
{{--                    @endforeach--}}
{{--                </select>--}}
{{--            </div>--}}
{{--            <div>--}}
{{--                <label>Target (optional)</label>--}}
{{--                <select wire:model="target_id" class="w-full">--}}
{{--                    <option value="">None</option>--}}
{{--                    @foreach($targets as $target)--}}
{{--                        <option value="{{ $target->id }}">{{ $target->name }}</option>--}}
{{--                    @endforeach--}}
{{--                </select>--}}
{{--            </div>--}}

{{--            <!-- Recurring Fields -->--}}
{{--            <div x-show="$wire.is_recurring == 1" x-cloak>--}}
{{--                <label>Recurrence</label>--}}
{{--                <select wire:model="recurrence" class="w-full">--}}
{{--                    <option value="">Select</option>--}}
{{--                    <option value="daily">Daily</option>--}}
{{--                    <option value="weekly">Weekly</option>--}}
{{--                    <option value="bi-weekly">Bi-weekly</option>--}}
{{--                    <option value="monthly">Monthly</option>--}}
{{--                </select>--}}
{{--            </div>--}}

{{--            <div x-show="$wire.is_recurring == 1" x-cloak>--}}
{{--                <label>Start Date</label>--}}
{{--                <input type="date" wire:model="start_date" class="w-full" />--}}
{{--            </div>--}}

{{--            <div x-show="$wire.is_recurring == 1" x-cloak>--}}
{{--                <label>End Date (optional)</label>--}}
{{--                <input type="date" wire:model="end_date" class="w-full" />--}}
{{--            </div>--}}

{{--            <!-- One-time Fields -->--}}
{{--            <div x-show="$wire.is_recurring == 0" x-cloak>--}}
{{--                <label>Due Date</label>--}}
{{--                <input type="date" wire:model="due_date" class="w-full" />--}}
{{--            </div>--}}
{{--        </div>--}}

{{--        <div class="mb-4">--}}
{{--            <label>Notes</label>--}}
{{--            <textarea wire:model="notes" class="w-full"></textarea>--}}
{{--        </div>--}}

{{--        <button wire:click="addChore" class="bg-blue-600 text-white px-4 py-2 rounded">--}}
{{--            Add to List--}}
{{--        </button>--}}
{{--    </div>--}}

{{--    <!-- Chores Preview Table -->--}}
{{--    @if (count($chores))--}}
{{--        <div class="border p-4 rounded shadow-md">--}}
{{--            <h2 class="text-lg font-semibold mb-4">Chores to Be Created</h2>--}}
{{--            <table class="w-full text-sm border-collapse">--}}
{{--                <thead>--}}
{{--                <tr class="bg-gray-100">--}}
{{--                    <th class="px-2 py-1 text-left">Action</th>--}}
{{--                    <th class="px-2 py-1 text-left">Location</th>--}}
{{--                    <th class="px-2 py-1 text-left">Target</th>--}}
{{--                    <th class="px-2 py-1 text-left">Date</th>--}}
{{--                    <th class="px-2 py-1 text-left">Recurrence</th>--}}
{{--                    <th></th>--}}
{{--                </tr>--}}
{{--                </thead>--}}
{{--                <tbody>--}}
{{--                @foreach($chores as $i => $chore)--}}
{{--                    <tr>--}}
{{--                        <td class="px-2 py-1">{{ $actions->find($chore['action_id'])?->name }}</td>--}}
{{--                        <td class="px-2 py-1">{{ $locations->find($chore['location_id'])?->name }}</td>--}}
{{--                        <td class="px-2 py-1">{{ $targets->find($chore['target_id'])?->name ?? '-' }}</td>--}}
{{--                        <td class="px-2 py-1">--}}
{{--                            {{ $chore['start_date'] }}--}}
{{--                            @if(!empty($chore['end_date']) && $chore['end_date'] !== $chore['start_date'])--}}
{{--                                - {{ $chore['end_date'] }}--}}
{{--                            @endif--}}
{{--                        </td>--}}
{{--                        <td class="px-2 py-1">--}}
{{--                            {{ $chore['recurrence'] !== 'none' ? ucfirst($chore['recurrence']) : 'One-time' }}--}}
{{--                        </td>--}}
{{--                        <td class="px-2 py-1">--}}
{{--                            <button wire:click="removeChore({{ $i }})" class="text-red-500 text-xs hover:underline">--}}
{{--                                Remove--}}
{{--                            </button>--}}
{{--                        </td>--}}
{{--                    </tr>--}}
{{--                @endforeach--}}
{{--                </tbody>--}}
{{--            </table>--}}

{{--            <button wire:click="saveAll" class="mt-4 bg-green-600 text-white px-4 py-2 rounded">--}}
{{--                Save All Chores--}}
{{--            </button>--}}
{{--        </div>--}}
{{--    @endif--}}


{{--    @if (session()->has('message'))--}}
{{--        <div class="text-green-600 font-semibold mt-2">--}}
{{--            {{ session('message') }}--}}
{{--        </div>--}}
{{--    @endif--}}
{{--</div>--}}
