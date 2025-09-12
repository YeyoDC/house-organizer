@php use Illuminate\Support\Facades\Storage; @endphp
@props([
    'user' => null,
    'size' => '8',
    'class' => '',
])

@php
    $user = $user ?? auth()->user();
    $profilePicture = $user->profile_picture;

    if ($profilePicture) {
        // Use Storage::url so it works with local/public or S3 automatically
        $src = Storage::url($profilePicture);
    } else {
        // Fallback default avatar (kept in public/storage for both envs)
        $src = asset('storage/default-avatar.png');
    }
@endphp


<img
    src="{{ $src }}"
    alt="Profile Picture"
    class="rounded-full object-cover border border-white w-{{ $size }} h-{{ $size }} {{ $class }}"
/>

