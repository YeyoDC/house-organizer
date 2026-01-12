@props([
    'user' => null,
    'size' => '8',
    'class' => '',
])

@php
    use Illuminate\Support\Facades\Storage;

    $user = $user ?? auth()->user();
    $profilePicture = $user?->profile_picture;

    $src = $profilePicture
        ? Storage::disk('s3')->url($profilePicture)
        : asset('images/default-avatar.png');
@endphp

<img
    src="{{ $src }}"
    alt="{{$user->name}}"
    class="rounded-full object-cover border border-white w-{{ $size }} h-{{ $size }} {{ $class }}"
/>


