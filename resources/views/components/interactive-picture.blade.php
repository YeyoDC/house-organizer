@props(['user' => auth()->user()])

@php
    $src = $user->profile_picture;
@endphp
<div x-data="{ menuOpen: false, viewImage: false, showUploadModal: false }" class="relative">

    <!-- Profile Picture Button -->
    <button @click="menuOpen = !menuOpen">
        <img src="{{ asset('storage/'.$src)}}" alt="Profile Picture"
             class="w-8 h-8 rounded-full object-cover border border-white" />
    </button>

    <!-- Dropdown Menu -->
    <div
        x-show="menuOpen"
        x-cloak
        @click.away="menuOpen = false"
        class="absolute right-0 mt-2 w-40 bg-white border rounded shadow z-50"
    >
        <button @click="viewImage = true; menuOpen = false" class="block w-full text-left px-4 py-2 hover:bg-gray-100">
            👁️ View Picture
        </button>

        <button
            type="button"
            @click="menuOpen = false; showUploadModal = true"
            class="block w-full text-left px-4 py-2 hover:bg-gray-100"
        >
            ✏️ Change Picture
        </button>
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

    <!-- Upload Modal -->
    <div
        x-show="showUploadModal"
        x-transition
        style="display: none;"
        class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center z-50"
        @click.away="showUploadModal = false"
        @keydown.escape.window="showUploadModal = false"
    >
        <form
            action="{{ route('profile.updatePicture') }}"
            method="POST"
            enctype="multipart/form-data"
            class="bg-white p-6 rounded shadow max-w-sm w-full"
            @click.stop
        >
            @csrf
            @method('PUT')

            <h2 class="text-lg font-semibold mb-4">Upload New Profile Picture</h2>

            <input
                type="file"
                name="profile_picture"
                accept="image/*"
                required
                class="mb-4 w-full"
            />

            <div class="flex justify-end space-x-2">
                <button type="button" @click="showUploadModal = false" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                    Cancel
                </button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Upload
                </button>
            </div>
        </form>
    </div>
</div>

