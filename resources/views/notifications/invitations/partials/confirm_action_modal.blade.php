@props([
    'actionType' => null,       // 'accept' or 'reject'
    'invitationId' => null,     // ID of the invitation
])
<x-modal name="confirm-action" focusable>
    <div class="p-6">
        <h2 class="text-lg font-semibold mb-4">
            Confirm {{ ucfirst($actionType) }} Invitation
        </h2>

        <p class="mb-4 text-sm text-gray-600">
            Are you sure you want to <span class="font-bold text-indigo-600">{{ $actionType }}</span> this invitation?
        </p>

        @if($actionType === 'accept')
            <div class="mb-4 p-3 bg-yellow-50 text-yellow-800 text-sm rounded border border-yellow-300">
                By accepting, if you are currently part of another household, you will be removed from that one. <br>
                If you own a household, it will be permanently deleted.
            </div>
        @endif

        <form method="POST" action="#">
            @csrf
            @if($actionType === 'reject')
                @method('DELETE')
            @endif

            <div class="flex justify-end space-x-2">
                <x-secondary-button x-on:click="$dispatch('close-modal', 'confirm-action')">
                    Cancel
                </x-secondary-button>

                <x-primary-button type="submit" class="bg-indigo-600 hover:bg-indigo-700">
                    {{ ucfirst($actionType) }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-modal>
