@php
    $assigned = $occurrence->assignedUser;

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

<div class="relative bg-gray-50 border rounded-lg p-4 mb-3 hover:bg-gray-100 transition">
    <div class="flex items-start justify-between">
        <!-- Chore Info -->
        <div class="pr-2">
            <div class="text-sm font-semibold text-gray-800">
                {{ $chore->action->name }}
            </div>
            <div class="text-xs text-gray-500">
                Room: {{ $chore->location->name }} &bull;
                {{ $chore->recurrence !== 'none' ? ucfirst($chore->recurrence) : 'One-time' }}
            </div>

            {{-- Notes (if any) --}}
            @if ($chore->notes)
                <div x-data="{ showNotes: false }" class="mt-1">
                    <button @click="showNotes = true"
                            class="text-xs text-blue-600 hover:underline flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
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

        <!-- Completion toggle & status -->
        <div class="flex flex-col items-end space-y-1">
            <button wire:click="toggleCompletion({{ $occurrence->id }})"
                    title="{{ $occurrence->is_completed ? 'Completed' : 'Mark as Complete' }}"
                    class="w-6 h-6 rounded-full border-2 flex items-center justify-center transition
                        {{ $occurrence->is_completed ? 'bg-green-500 border-green-500 text-white' : 'border-gray-400 text-gray-400 hover:bg-gray-100' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M5 13l4 4L19 7" />
                </svg>
            </button>
            <span class="text-xs font-semibold {{ $statusColor }}">{{ $statusText }}</span>
        </div>
    </div>
</div>
