{{-- resources/views/components/navigation/hamburger-menu.blade.php --}}
<div x-data="{ open: false }" class="relative z-50">
    <!-- Hamburger Button -->
    <button @click="open = true" class="p-2 bg-white">
        <svg class="w-6 h-6 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M4 6h16M4 12h16M4 18h16" />
        </svg>
    </button>

    <!-- Backdrop -->
    <div x-show="open"
         x-transition.opacity
         @click="open = false"
         class="fixed inset-0 bg-black bg-opacity-50 z-40">
    </div>


    <div x-show="open"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="-translate-x-full"
         x-transition:enter-end="translate-x-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="translate-x-0"
         x-transition:leave-end="-translate-x-full"
         class="fixed top-0 left-0 w-64 h-full bg-white shadow z-50 transform transition-transform flex flex-col pb-20"
         @click.away="open = false">

        <div class="p-4 flex justify-between items-center border-b">
            <span class="font-semibold">Menu</span>
            <button @click="open = false">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <nav class="p-4 space-y-2 flex-grow overflow-auto">
            <a href="{{route('household.manage')}}" class="block py-2 px-4 hover:bg-gray-100 rounded">👥 Household</a>
        </nav>

        <div class="p-4 border-t">
            <a href="{{route('profile.edit')}}" class="block py-2 px-4 hover:bg-gray-100 rounded">⚙️ Settings</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="block w-full text-left py-2 px-4 hover:bg-gray-100 rounded">
                    🔒 Logout
                </button>
            </form>
        </div>
    </div>


</div>
