@props(['title' => ''])

    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }}</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>
@if(session('success'))
    <x-flash-alerts :message="session('success')" type="success" />
@endif

@if(session('error'))
    <x-flash-alerts :message="session('error')" type="error" />
@endif


<body class="bg-gray-100 min-h-screen">

<div class="grid sm:grid-cols-[16rem_1fr] grid-rows-[auto_1fr] min-h-screen">
    {{-- Sidebar (desktop) --}}
    <aside class="hidden sm:block sm:row-span-2 bg-slate-300-500 border-r">
        <x-navigation.desktop />
    </aside>

    {{-- Header --}}
    <header class="sticky top-0 z-40 flex items-center justify-between px-4 h-14 bg-white shadow z-40
                       sm:col-start-2 sm:row-start-1">
        <!-- Left (mobile only): Hamburger -->
        <div class="sm:hidden">
            <x-navigation.hamburger-menu />
        </div>

        <!-- Center: Page Title -->
        <div class="text-white font-semibold text-lg text-center flex-1 -ml-8">
            {{ $header ?? '' }}
        </div>

        <!-- Right: Profile Picture -->
        <div>
            <x-interactive-picture />
        </div>
    </header>

    {{-- Main Content --}}
    <main class="px-4 sm:px-6 lg:px-8 py-4 pb-20 sm:col-start-2 sm:row-start-2">
        {{ $slot }}
    </main>
</div>

{{-- Mobile Bottom Navigation --}}
<x-navigation.mobile />

</body>
</html>
