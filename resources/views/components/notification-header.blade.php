<div
    x-data="{ show: false }"
    x-init="setTimeout(() => show = true, 100)"
    x-show="show"
    x-transition:enter="transition ease-out duration-500"
    x-transition:enter-start="opacity-0 translate-y-2"
    x-transition:enter-end="opacity-100 translate-y-0"
    class="p-4 bg-white rounded shadow flex items-center space-x-4"
>
    <!-- Icon -->
    <div class="flex-shrink-0">
        <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2"
             viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-5-5.917V5a2 2 0 10-4 0v.083A6.002 6.002 0 004 11v3.159c0 .538-.214 1.055-.595 1.436L2 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
        </svg>
    </div>

    <!-- Text -->
    <div>
        <h1 class="text-xl font-semibold text-gray-800">{{ $title ?? 'Welcome to your Notifications' }}</h1>
        <p class="text-sm text-gray-500">{{ $subtitle ?? 'Stay updated with invites, changes, and more.' }}</p>
    </div>
</div>
