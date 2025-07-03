<x-app-layout title="Dashboard">
    <x-slot name="header">
        <h1 class="text-gray-500 text-lg font-semibold">Welcome, {{ Auth::user()->usernamename ?? Auth::user()->name }}</h1>
    </x-slot>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="p-4 bg-white rounded shadow">
            <h2 class="font-bold mb-2">Household</h2>
            <p>View or manage your household members.</p>
        </div>
        <div class="p-4 bg-white rounded shadow">
            <h2 class="font-bold mb-2">Tasks</h2>
            <p>See what’s on your to-do list today.</p>
        </div>
        <div class="p-4 bg-white rounded shadow">
            <h2 class="font-bold mb-2">Household</h2>
            <p>View or manage your household members.</p>
        </div>
        <div class="p-4 bg-white rounded shadow">
            <h2 class="font-bold mb-2">Tasks</h2>
            <p>See what’s on your to-do list today.</p>
        </div>
        <div class="p-4 bg-white rounded shadow">
            <h2 class="font-bold mb-2">Household</h2>
            <p>View or manage your household members.</p>
        </div>
        <div class="p-4 bg-white rounded shadow">
            <h2 class="font-bold mb-2">Tasks</h2>
            <p>See what’s on your to-do list today.</p>
        </div>
        <div class="p-4 bg-white rounded shadow">
            <h2 class="font-bold mb-2">Household</h2>
            <p>View or manage your household members.</p>
        </div>
        <div class="p-4 bg-white rounded shadow">
            <h2 class="font-bold mb-2">Tasks</h2>
            <p>See what’s on your to-do list today.</p>
        </div>
    </div>
</x-app-layout>

