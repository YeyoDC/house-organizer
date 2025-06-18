@props(['name' => 'profile_picture', 'preview' => null])

<div>
    <label class="block font-medium text-sm text-gray-700 mb-2">
        {{ __('Profile Picture') }}
    </label>

    <input type="file"
           name="{{ $name }}"
           id="{{ $name }}"
           accept="image/*"
           class="block w-full text-sm text-gray-500
                  file:mr-4 file:py-2 file:px-4
                  file:rounded file:border-0
                  file:text-sm file:font-semibold
                  file:bg-indigo-50 file:text-indigo-700
                  hover:file:bg-indigo-100">

    @if ($preview)
        <div class="mt-2">
            <img src="{{ asset('storage/' . $preview) }}" alt="Current profile picture" class="w-20 h-20 rounded-full object-cover">
        </div>
    @endif
</div>
