{{-- resources/views/components/navigation/desktop.blade.php --}}
<div class="h-full flex flex-col justify-between p-4">
    <nav class="space-y-4">
        <a href="{{route('dashboard')}}" class="block text-gray-700 hover:text-indigo-600 font-medium">🏠 Dashboard</a>
        <a href="{{route('chores.index')}}" class="block text-gray-700 hover:text-indigo-600 font-medium">🧹 Chores</a>
        <a href="{{route('groceries.index')}}" class="block text-gray-700 hover:text-indigo-600 font-medium">🛒 Groceries</a>
        <a href="{{route('invite.index')}}" class="block text-gray-700 hover:text-indigo-600 font-medium">🔔 Alerts</a>
        <a href="{{route('household.manage')}}" class="block text-gray-700 hover:text-indigo-600 font-medium">👥 Household</a>
    </nav>
    <div>
        <a href="#" class="text-sm text-gray-500 hover:text-indigo-500">⚙️ Settings</a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="block w-full text-left py-2 px-4 hover:bg-gray-100 rounded text-sm">
                🔒 Logout
            </button>
        </form>
    </div>
</div>
