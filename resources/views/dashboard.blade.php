<x-app-layout title="Dashboard">
    <x-slot name="header">
        <h1 class="text-gray-500 text-lg font-semibold">Welcome, {{ Auth::user()->usernamename ?? Auth::user()->name }}</h1>
    </x-slot>

    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-6 rounded-md shadow-md">
        <h2 class="text-xl font-bold text-yellow-800 mb-2">🚧 Under Development</h2>
        <p class="text-gray-700 mb-4">
            We're excited to share that the <span class="font-semibold text-green-700">first phase</span> of the app is rolling out soon! This initial release will include:
        </p>
        <ul class="list-disc list-inside text-gray-800 mb-4">
            <li><span class="font-medium text-blue-700">Chores</span> — Track and manage household tasks effortlessly</li>
            <li><span class="font-medium text-blue-700">Groceries</span> — Organize your shopping list with smart features</li>
        </ul>
        <p class="text-gray-600 italic">
            Coming soon: <span class="font-semibold text-purple-700">Finances</span>, <span class="font-semibold text-purple-700">Recipes</span>, and <span class="font-semibold text-purple-700">Statistics</span> to help you manage your home like a pro.
        </p>
    </div>
</x-app-layout>

