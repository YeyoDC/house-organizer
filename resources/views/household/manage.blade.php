<x-app-layout title="household manager">
    <div class="grid grid-cols-1 md:grid-cols-1 gap-4">
        <div class="p-4 bg-white rounded shadow">
            @if(!$household)
                @include('household.partials.household_form')
            @endif
            @if($household)
                {{-- if they have created a household already --}}
                <div class="flex items-center justify-center space-x-4 mb-4">
                    <h1 class="font-bold text-xl">{{ $household->name }}</h1>
                    <x-household-picture :household="$household" size="9" class="shadow-md" />

                </div>

                <div class="justify-center space-x-4">
                        @include('household.partials.members')
                </div>

                @include('household.partials.add_member_modal')
                @include('household.partials.leave_household_modal')
            @endif

        </div>
    </div>
</x-app-layout>
