<x-modal name="add-member">
    <div class="p-6">
        <h2 class="text-lg font-semibold mb-4">Add Member</h2>

        <form method="POST" action="{{route('invite.store')}}">
            @csrf

            <div class="mb-4">
                <x-input-label for="email" value="User Email" />
                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" required autofocus />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="flex justify-end space-x-2">
                <x-secondary-button x-on:click="$dispatch('close-modal', 'add-member')">
                    Cancel
                </x-secondary-button>
                <x-primary-button type="submit" class="bg-blue-300">
                    Add Member
                </x-primary-button>
            </div>
        </form>
    </div>
</x-modal>

