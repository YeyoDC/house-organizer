@props([
    'household' => null,
    'size' => '12',  // default size for group picture
    'class' => '',
])

@php
    $picture = $household?->picture;
    $src = $picture ? asset('storage/' . $picture) : asset('storage/default-household.png');
@endphp

<img
    src="{{ $src }}"
    alt="{{ $household?->name ?? 'Household Picture' }}"
    class="rounded-full object-cover border border-white w-{{ $size }} h-{{ $size }} {{ $class }}"
/>

