<h2 class="font-bold text-center text-lg mb-4">MEMBERS</h2>
{{-- only show Admin to add members--}}
    @if($user->isAdmin())
    <!-- Add member button -->
    <div class="flex justify-center mb-4">
        <button
            x-data
            x-on:click="$dispatch('open-modal', 'add-member')"
            class="flex items-center px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500"
        >
            <span class="text-sm mr-2 font-bold">+</span> Add Member
        </button>
    </div>
    @endif

    <div class="flex space-y-1">

    </div>
    <!-- Members list -->
    <div class="space-y-0">
        @foreach ($members as $member)
            <div class="flex items-center justify-between space-x-4 p-2 rounded hover:bg-gray-100">
                <div class="flex items-center space-x-3">
                    <!-- Profile picture -->
{{--                    <x-profile-picture :user="$member" size="8" class="rounded-full border border-gray-300" />--}}

                    <!-- Name and badges -->
                    <div class="text-sm">
                        <p class="font-medium flex items-center space-x-2">
                            <span>{{ $member->name }}</span>

                            @if ($member->id === auth()->id())
                                <span class="text-gray-500 text-xs italic">(you)</span>
                            @endif

                            @if ($member->id == $household->owner_id)
                            <span class="bg-green-100 text-green-800 text-xs px-1.5 py-0.5 rounded font-semibold">Admin</span>
                            @endif
                        </p>
                        @if ($member->id === auth()->id())
                            <div class="mt-1">
                                <button
                                    x-data
                                    x-on:click="$dispatch('open-modal', 'leave-household')"
                                    class="px-2 py-1 text-xs font-semibold bg-red-300 text-red-800 rounded hover:bg-red-200"
                                >
                                    Leave household
                                </button>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Delete button if current user is owner and member isn't self -->
                @if ($household->owner_id === auth()->id() && $member->id !== auth()->id())
                    <button
                        type="button"
                        onclick="confirmDeleteMember({{ $member->id }})"
                        class="text-red-600 hover:text-red-800 focus:outline-none"
                        aria-label="Remove {{ $member->name }}"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                @endif
            </div>
        @endforeach
    </div>

