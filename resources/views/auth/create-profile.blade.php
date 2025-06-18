<x-guest-layout>
    <form method="POST" action = {{ route('register') }}>
        @csrf
        <div>
            <x-input-label for="displayName" :value="__('display name')" />
            <x-text-input id="displayName" class="block mt-1 w-full" type="text" name="displayName" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

    </form>
</x-guest-layout>
