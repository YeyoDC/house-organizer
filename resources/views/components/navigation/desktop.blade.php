{{-- resources/views/components/navigation/desktop.blade.php --}}
<div class="h-full flex flex-col justify-between p-4">
    <nav class="space-y-4">
        <a href="#" class="block text-gray-700 hover:text-indigo-600 font-medium">🏠 Dashboard</a>
        <a href="#" class="block text-gray-700 hover:text-indigo-600 font-medium">🧹 Chores</a>
        <a href="#" class="block text-gray-700 hover:text-indigo-600 font-medium">🛒 Groceries</a>
        <a href="#" class="block text-gray-700 hover:text-indigo-600 font-medium">🔔 Alerts</a>
    </nav>
    <div>
        <a href="#" class="text-sm text-gray-500 hover:text-indigo-500">⚙️ Settings</a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="block w-full text-left py-2 px-4 hover:bg-gray-100 rounded">
                🔒 Logout
            </button>
        </form>
    </div>
</div>
