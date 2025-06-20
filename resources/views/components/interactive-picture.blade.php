@props(['user' => auth()->user()])

@php
    $profilePicture = $user->profile?->profile_picture;
    $src = $profilePicture ? asset('storage/' . $profilePicture) : asset('storage/default-avatar.png');
@endphp

<div x-data="{ menuOpen: false, viewImage: false }" class="relative">
    <!-- Profile Picture Button -->
    <button @click="menuOpen = !menuOpen">
        <img src="{{ $src }}" alt="Profile Picture"
             class="w-8 h-8 rounded-full object-cover border border-white" />
    </button>

    <!-- Dropdown Menu -->
    <div
        x-show="menuOpen"
        @click.away="menuOpen = false"
        class="absolute right-0 mt-2 w-40 bg-white border rounded shadow z-50"
    >
        <button @click="viewImage = true; menuOpen = false" class="block w-full text-left px-4 py-2 hover:bg-gray-100">
            👁️ View Picture
        </button>
        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 hover:bg-gray-100">
            ✏️ Change Picture
        </a>
    </div>

    <!-- Image Modal -->
    <div
        x-show="viewImage"
        x-transition
        style="display: none;"
        class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center z-50"
        @click.away="viewImage = false"
        @keydown.escape.window="viewImage = false"
    >
        <img src="{{ $src }}"
             alt="Full Size Profile Picture"
             class="max-w-xs max-h-[80vh] rounded-full shadow-xl" />
    </div>
</div>
