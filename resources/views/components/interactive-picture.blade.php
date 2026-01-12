@props(['user' => auth()->user()])
@php
    use Illuminate\Support\Facades\Storage;

    $src = $user->profile_picture
        ? Storage::url($user->profile_picture)
        : asset('images/default-avatar.png');
@endphp
<div x-data="{ menuOpen: false, viewImage: false, showUploadModal: false }" class="relative">

    <!-- Profile Picture Button -->
    <button @click="menuOpen = !menuOpen">
{{--        <img src="{{ $src }}" alt="Profile Picture"--}}
{{--             class="w-8 h-8 rounded-full object-cover border border-white shadow" />--}}
        <x-profile-picture :user="$user" size="8" class="shadow-md" />
    </button>

    <!-- Dropdown Menu -->
    <div
        x-show="menuOpen"
        x-cloak
        @click.away="menuOpen = false"
        class="absolute right-0 mt-2 w-44 bg-white border rounded shadow z-50"
    >
        <button @click="viewImage = true; menuOpen = false"
                class="block w-full text-left px-4 py-2 hover:bg-gray-100">
            👁️ View Picture
        </button>

        <button type="button"
                @click="menuOpen = false; showUploadModal = true"
                class="block w-full text-left px-4 py-2 hover:bg-gray-100">
            ✏️ Change Picture
        </button>
    </div>

    <!-- View Picture Modal (circular only) -->
    <div
        x-show="viewImage"
        x-transition
        x-cloak
        class="fixed inset-0 bg-black bg-opacity-80 flex items-center justify-center z-50"
        @keydown.escape.window="viewImage = false"
    >
        <div @click.away="viewImage = false" class="p-4">
            <img src="{{ $src }}"
                 alt="Full Size Profile Picture"
                 class="rounded-full w-48 h-48 object-cover border-4 border-white shadow-lg" />
        </div>
    </div>

    <!-- Upload Modal -->
    <div
        x-show="showUploadModal"
        x-transition
        x-cloak
        class="fixed inset-0 bg-black bg-opacity-80 flex items-center justify-center z-50"
        @keydown.escape.window="showUploadModal = false"
    >
        <div @click.away="showUploadModal = false"
             class="bg-gradient-to-br from-purple-50 to-indigo-100 p-6 rounded-xl shadow-2xl max-w-sm w-full border border-indigo-300">
            <form
                action="{{ route('profile.updatePicture') }}"
                method="POST"
                enctype="multipart/form-data"
                @click.stop
            >
                @csrf
                @method('PUT')

                <h2 class="text-xl font-bold text-indigo-800 mb-4 text-center">Upload New Picture</h2>

                <input type="file" name="profile_picture" accept="image/*" required
                       class="w-full text-sm p-2 border-2 border-indigo-300 rounded focus:outline-none focus:ring-2 focus:ring-indigo-500 mb-4 bg-white" />

                <div class="flex justify-between">
                    <button type="button"
                            @click="showUploadModal = false"
                            class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400 text-sm transition">
                        Cancel
                    </button>
                    <button type="submit"
                            class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 text-sm font-semibold transition">
                        Upload
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

