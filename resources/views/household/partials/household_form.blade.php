<section class="mt-8">
    <header>
        <h2 class="text-lg font-medium text-center text-gray-900">
            {{ __('Create Household') }}
        </h2>
        <br>
        <p class="mt-1 text-sm text-gray-600">
            {{ __("Set up a household to manage members and shared resources.") }}
        </p>
    </header>

    <form method="POST" action="{{ route('household.store') }}" class="mt-6 space-y-6">
        @csrf

        <!-- Household Name -->
        <div>
            <x-input-label for="name" :value="__('Household Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" required autofocus autocomplete="off" placeholder="e.g., Cuellar Family" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <!-- Optional: Description -->
        <div>
            <x-input-label for="description" :value="__('Description')" />
            <textarea
                id="description"
                name="description"
                rows="3"
                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                placeholder="Optional: Describe your household"
            >{{ old('description') }}</textarea>
            <x-input-error class="mt-2" :messages="$errors->get('description')" />
        </div>

        <!-- Submit Button -->
        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Create Household') }}</x-primary-button>

            @if (session('status') === 'household-created')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-green-600"
                >{{ __('Household created.') }}</p>
            @endif
        </div>
    </form>
</section>

