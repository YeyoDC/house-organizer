<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 mt-6 space-y-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Your Chores This Week</h1>
        <a href="/chores/manage"
           class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
            Manage chores +
        </a>
    </div>

    @forelse($groupedOccurrences as $date => $items)
        <div class="bg-white shadow border rounded-xl p-4">

            {{-- Date + Controls Row --}}
            <div class="flex items-center justify-between mb-3">
                <h2 class="text-lg font-bold text-indigo-700">
                    {{ \Carbon\Carbon::parse($date)->format('l, M j') }}
                </h2>

                @php
                    $firstOccurrence = $items->first()['occurrence'];
                @endphp

            </div>

            {{-- Chore cards --}}
            @foreach($items as $item)
                @php
                    $chore = $item['chore'];
                    $occurrence = $item['occurrence'];
                @endphp

                <x-chore-chard :chore="$chore" :occurrence="$occurrence" />
            @endforeach
        </div>
    @empty
        <div class="bg-blue-50 text-green-700 p-4 rounded-md text-center">
            🎉 You have no chores assigned for the next 7 days.
        </div>
    @endforelse
</div>



