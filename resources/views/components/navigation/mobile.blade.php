{{-- resources/views/components/navigation/mobile.blade.php --}}
@php
    $routeName = request()->route()->getName();
@endphp

<nav class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 shadow sm:hidden z-40">
    <div class="flex justify-around items-center h-14 text-sm">
        <a href="{{route('dashboard')}}"  class="{{ $routeName === 'chores.index' ? 'text-indigo-600 font-semibold' : '' }}">🏠 <span class="block text-xs"> Home </span></a>
        <a href="#" class="{{ $routeName === 'chores.index' ? 'text-indigo-600 font-semibold' : '' }}">🧹<span class="block text-xs">Chores</span></a>
        <a href="#" class="{{ $routeName === 'groceries.index' ? 'text-indigo-600 font-semibold' : '' }}">🛒<span class="block text-xs">Groceries</span></a>
        <a href="{{route('invite.index')}}" class="{{ $routeName === 'alerts.index' ? 'text-indigo-600 font-semibold' : '' }}">🔔<span class="block text-xs">Alerts</span></a>
    </div>
</nav>
