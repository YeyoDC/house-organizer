<div class="space-y-4">
    <div class="mb-4 flex items-center justify-between space-x-4">
        <button wire:click="goToPreviousMonth" class="px-3 py-1 bg-gray-200 hover:bg-gray-300 rounded shadow text-sm">
            ◀
        </button>

        <div class="flex-1">
            <label class="font-semibold block text-sm text-gray-700 mb-1 text-center">Filter by Month:</label>
            <input type="month"
                   value="{{ $filterMonth }}"
                   wire:input="setFilterMonth($event.target.value)"
                   class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"/>
        </div>

        <button wire:click="goToNextMonth" class="px-3 py-1 bg-gray-200 hover:bg-gray-300 rounded shadow text-sm">
            ▶
        </button>
    </div>
    {{-- Add Chore Button --}}
    <div class="flex justify-start mb-4 px-2">
        <a  href="{{route('chores.create-batch')}}"
            class="inline-flex items-center space-x-1 bg-purple-600 hover:bg-purple-700 text-white text-xs font-semibold px-3 py-1 rounded shadow transition focus:outline-none cursor-pointer"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            <span>Add Chore</span>
        </a>

    </div>
    {{--avatars filter--}}
    <div class="flex justify-start gap-2 flex-wrap py-2">
        @foreach ([['label' => 'All', 'value' => ''], ['label' => 'Unassigned', 'value' => 'unassigned'], ['label' => 'Assigned', 'value' => 'assigned']] as $filter)
            <button
                wire:click="$set('filterAssigned', '{{ $filter['value'] }}')"
                class="px-3 py-1 text-xs rounded-full font-medium
                {{ $filterAssigned === $filter['value'] ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-800' }}">
                {{ $filter['label'] }}
            </button>
        @endforeach
    </div>

    <div class="overflow-x-auto -mx-2 px-2">
        <div class="flex space-x-3 pb-2">
            @foreach ($members as $member)
                <button
                    wire:click="$set('filterAssigned', {{ $member->id }})"
                    class="flex flex-col items-center space-y-1 px-2 py-1 rounded cursor-pointer
                    {{ $filterAssigned == $member->id ? 'bg-blue-600 text-white' : 'bg-gray-100' }}">
                    <img src="{{ asset('storage/'.$member->profile_picture) }}"
                         alt="{{ $member->name }}"
                         class="w-10 h-10 rounded-full object-cover border border-white shadow-sm"/>
                    <span class="text-[10px] truncate max-w-[50px] text-center">{{ $member->name }}</span>
                </button>
            @endforeach
        </div>
    </div>

    @forelse($groupedOccurrences as $date => $items)
        <div class="bg-white shadow border rounded-xl p-4">
            <h2 class="text-lg font-bold text-indigo-700 mb-3">
                {{ \Carbon\Carbon::parse($date)->format('l, M j') }}
            </h2>

            @foreach($items as $item)
                @php
                    $chore = $item['chore'];
                    $occurrence = $item['occurrence'];
                    $assigned = $occurrence->assignedUser;
                    $creator = $chore->creator;
                @endphp

                <div class="relative bg-gray-50 border rounded-lg p-4 mb-3 hover:bg-gray-100 transition">
                    <div class="flex items-start justify-between">
                        <div class="pr-2">
                            <div class="text-sm font-semibold text-gray-800">{{ $chore->action->name }}</div>
                            <div class="text-xs text-gray-500">
                                Room: {{ $chore->location->name }} &bull;
                                {{ $chore->recurrence !== 'none' ? ucfirst($chore->recurrence) : 'One-time' }}
                            </div>
                            @if ($chore->notes)
                                <div x-data="{ showNotes: false }" class="mt-1">
                                    <button @click="showNotes = true"
                                            class="text-xs text-blue-600 hover:underline flex items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M13 16h-1v-4h-1m1-4h.01M12 20h.01"/>
                                        </svg>
                                        View Notes
                                    </button>

                                    <div x-show="showNotes" @click.away="showNotes = false"
                                         class="absolute z-50 bg-white border border-gray-200 rounded shadow-lg p-3 w-64 text-xs text-gray-700 mt-2">
                                        <div class="font-semibold text-gray-800 mb-1">Notes</div>
                                        <div class="whitespace-pre-line">{{ $chore->notes }}</div>
                                        <div class="mt-2 text-right">
                                            <button @click="showNotes = false" class="text-xs text-blue-600 hover:underline">Close</button>
                                        </div>
                                    </div>
                                </div>
                            @endif

                        </div>

                        <div class="flex flex-col items-end space-y-2">

{{--                            --}}

                            <div x-data="{ open: @entangle('showUserListFor').defer === {{ $occurrence->id }} }"
                                 class="relative inline-block"  {{-- make this relative and inline-block --}}
                                 @click.away="open = false; $wire.set('showUserListFor', null)"
                                 x-init="$watch('open', value => {
         if (!value) $wire.set('showUserListFor', null)
     })">

                                @if($assigned)
                                    <button @click="open = !open; $wire.set('showUserListFor', {{ $occurrence->id }})"
                                            class="flex items-center space-x-1">
                                        <img src="{{ asset('storage/'.$assigned->profile_picture) }}"
                                             class="w-8 h-8 rounded-full object-cover border border-gray-300"
                                             alt="avatar"/>
                                        <span
                                            class="text-xs text-green-700 bg-green-100 px-2 py-1 rounded-full font-medium flex items-center space-x-1">
                <span>{{ $assigned->name }}</span>
                <svg class="w-3 h-3 text-green-700" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                          d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.25a.75.75 0 01-1.06 0L5.21 8.29a.75.75 0 01.02-1.08z"
                          clip-rule="evenodd"/>
                </svg>
            </span>
                                    </button>
                                @else
                                    <button @click="open = !open; $wire.set('showUserListFor', {{ $occurrence->id }})"
                                            class="text-xs text-yellow-800 bg-yellow-100 px-2 py-1 rounded-full font-medium flex items-center space-x-1">
                                        <span>Unassigned</span>
                                        <svg class="w-3 h-3 text-yellow-800" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                  d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.25a.75.75 0 01-1.06 0L5.21 8.29a.75.75 0 01.02-1.08z"
                                                  clip-rule="evenodd"/>
                                        </svg>
                                    </button>
                                @endif

                                <template x-if="open">
                                    <div class="absolute left-0 top-full mt-1 min-w-[180px] p-2 border rounded bg-white shadow-lg text-sm z-50">
                                        @foreach ($members as $user)
                                            <div class="flex items-center gap-2 py-1 hover:bg-gray-100 px-2 rounded cursor-pointer"
                                                 wire:click="assignTo({{ $occurrence->id }}, {{ $user->id }})"
                                                 @click="open = false; $wire.set('showUserListFor', null)">
                                                <img src="{{ asset('storage/'.$user->profile_picture) }}"
                                                     alt="{{ $user->name }}"
                                                     class="w-6 h-6 rounded-full">
                                                <span>{{ $user->name }}</span>
                                            </div>
                                        @endforeach
                                        <div class="flex items-center gap-2 py-1 hover:bg-gray-100 px-2 rounded cursor-pointer"
                                             wire:click="assignTo({{ $occurrence->id }}, null)"
                                             @click="open = false; $wire.set('showUserListFor', null)">
                                            <div class="w-6 h-6 rounded-full bg-yellow-300 flex items-center justify-center text-yellow-900 font-semibold">
                                                Un
                                            </div>
                                            <span>Unassign</span>
                                        </div>
                                    </div>
                                </template>
                            </div>

                            {{--                            --}}
                        </div>
                    </div>

                    {{-- Status + Manage Dropdown --}}
                    <div class="flex items-center justify-between w-full mt-2 space-x-4">
                        {{-- Manage Dropdown --}}
                        <div x-data="{ open: false, confirm: false }" @close-dropdown.window="open = false; confirm = false" class="relative w-max mt-2">

                            <!-- Manage button -->
                            <button @click="open = !open; confirm = false"
                                    class="text-xs px-2 py-1 bg-cyan-800 text-white font-semibold rounded shadow flex items-center gap-1 hover:bg-purple-700 transition w-full justify-between">
                                Manage
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                          d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.25a.75.75 0 01-1.06 0L5.21 8.29a.75.75 0 01.02-1.08z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </button>

                            <!-- Main Manage menu -->
                            <div x-show="open" @click.away="open = false; confirm = false"
                                 class="mt-1 w-max bg-white border border-gray-200 rounded shadow z-20 text-sm absolute left-0"
                                 style="min-width: max-content;">
                                <ul class="py-1">
                                    <li>
                                        <button wire:click="toggleCompletion({{ $occurrence->id }})"
                                                @click="$dispatch('close-dropdown')"
                                                class="w-auto text-left px-4 py-2 hover:bg-gray-100 text-gray-700 text-xs block min-w-[150px]">
                                            @if(!$occurrence->is_completed)
                                                Mark as Completed
                                            @else
                                                Mark as Incomplete
                                            @endif
                                        </button>
                                    </li>

                                    <li>
                                        <button @click.stop="confirm = true; open = false"
                                                class="w-auto text-left px-4 py-2 hover:bg-gray-100 text-red-600 text-xs block min-w-[150px]">
                                            Remove
                                        </button>
                                    </li>

                                    <li>
                                        <button class="w-auto text-left px-4 py-2 hover:bg-gray-100 text-gray-700 text-xs block min-w-[150px]">
                                            Edit
                                        </button>
                                    </li>
                                </ul>
                            </div>

                            <!-- Confirmation submenu (separate, below) -->
                            <div x-show="confirm" @click.away="confirm = false"
                                 class="mt-2 w-max bg-gray-50 border border-gray-200 rounded shadow-inner absolute left-0 z-30 text-xs"
                                 style="min-width: max-content;">
                                <button
                                    wire:click="$dispatch('close-dropdown'); @this.deleteChore({{ $occurrence->id }}, false); confirm = false"
                                    class="w-auto text-left px-4 py-2 hover:bg-gray-100 text-gray-800 block min-w-[150px]">
                                    Just this occurrence
                                </button>
                                <button
                                    wire:click="$dispatch('close-dropdown'); @this.deleteChore({{ $occurrence->id }}, true); confirm = false"
                                    class="w-auto text-left px-4 py-2 hover:bg-gray-100 text-red-600 block min-w-[150px]">
                                    Entire series
                                </button>
                                <button @click="confirm = false"
                                        class="w-auto text-left px-4 py-2 hover:bg-gray-200 text-gray-600 block min-w-[150px]">
                                    Cancel
                                </button>
                            </div>

                        </div>


                        {{-- Status --}}
                        <div class="flex items-end space-x-2">
                            <span class="text-xs font-semibold text-gray-600">Status:</span>
                            @php
                                $now = now();
                                $due = $occurrence->due_date;
                                $completedAt = $occurrence->completed_at ?? null;

                                if ($occurrence->is_completed) {
                                    if ($completedAt && $completedAt->gt($due)) {
                                        $statusText = 'Late Completed';
                                        $statusColor = 'text-orange-500';
                                    } else {
                                        $statusText = 'Completed';
                                        $statusColor = 'text-green-700';
                                    }
                                } else {
                                    if ($due->lt($now)) {
                                        $statusText = 'Expired';
                                        $statusColor = 'text-red-600';
                                    } else {
                                        $statusText = 'Pending';
                                        $statusColor = 'text-gray-500';
                                    }
                                }
                            @endphp
                            <span class="text-xs font-semibold {{ $statusColor }}">
            {{ $statusText }}
        </span>
                        </div>
                    </div>



                </div>  <!--do not touch div -->
            @endforeach
        </div>
    @empty
        <div class="text-center text-gray-500 mt-8">
            No chores found for this month.
        </div>
    @endforelse
</div>
