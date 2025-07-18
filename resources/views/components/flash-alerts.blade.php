
@props(['message', 'type' => 'success'])

<div
    x-data="{ show: true }"
    x-show="show"
    x-transition
    x-init="setTimeout(() => show = false, 4000)"
    class="fixed top-4 right-4 z-50 px-4 py-2 rounded shadow flex items-center space-x-2 text-white
        {{ $type === 'success' ? 'bg-green-500' : 'bg-red-500' }}"
    role="alert"
>
    @if($type === 'success')
        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2"
             viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
    @else
        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2"
             viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M6 18L18 6M6 6l12 12" />
        </svg>
    @endif

    <span>{{ $message }}</span>

    <!-- Optional close button -->
    <button @click="show = false" class="ml-2 text-white hover:text-gray-200 focus:outline-none">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
             viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>
</div>
