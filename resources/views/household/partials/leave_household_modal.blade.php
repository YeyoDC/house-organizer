<x-modal name="leave-household" x-data="{household: null}">
    <div class="p-6">
        <h2 class="text-lg font-semibold mb-4 text-center text-red-800">
            ⚠️ Leave Household
        </h2>

        <h3>Are you sure you want to leave?</h3>
        @if($user->ownedHousehold)
            <div class="mb-4 p-3 bg-yellow-50 text-yellow-800 text-sm rounded border border-yellow-300">
                <span>If you leave, your household <strong>{{$user->ownedHousehold->name}}</strong> will be deleted</span>
            </div>
        @endif
        <form method="POST" action="{{route('household.update', $user->household_id)}}">
            @csrf
            @method('PUT')
            <div class="flex justify-center space-x-10">
                <x-secondary-button x-on:click="$dispatch('close-modal', 'leave-household')">
                    Cancel
                </x-secondary-button>
                <x-primary-button type="submit" class="bg-blue-300">
                    Leave
                </x-primary-button>
            </div>
        </form>
    </div>
</x-modal>
