<x-guest-layout>
    <form method="POST" action = "{{ route('profile.complete.store') }}" enctype="multipart/form-data" >
        @csrf
        <x-profile-picture-uploader :preview="$user->profile?->profile_picture" />
        {{--Preferred Name--}}
        <div>
            <x-input-label for="displayName" :value="__('display name')" />
            <x-text-input id="displayName" class="block mt-1 w-full" type="text" name="displayName" :value="old('displayName')" required autofocus autocomplete="displayName" />
            <x-input-error :messages="$errors->get('displayName')" class="mt-2" />
        </div>
        {{--        --}}
        <div>
            <x-input-label for="phone" :value="__('phone')" />
            <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" required autofocus autocomplete="phone" />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>
        <div>
            <x-primary-button>
                {{__('Save')}}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
