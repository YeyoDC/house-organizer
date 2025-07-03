@props([
    'user' => null,
    'size' => '8',
    'class' => '',
])

@php
    $user = $user ?? auth()->user();
    $profilePicture = $user->profile_picture;
    $src = $profilePicture ? asset($profilePicture) : asset('storage/default-avatar.png');
@endphp

<img
    src="{{ $src }}"
    alt="Profile Picture"
    class="rounded-full object-cover border border-white w-{{ $size }} h-{{ $size }} {{ $class }}"
/>

