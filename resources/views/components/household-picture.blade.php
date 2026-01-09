@props([
    'household' => null,
    'size' => '12',
    'class' => '',
])

@php
    use Illuminate\Support\Facades\Storage;

    $picture = $household?->picture;

    $src = $picture
        ? Storage::disk('s3')->url($picture)
        : asset('images/default-household.png');
@endphp

<img
    src="{{ $src }}"
    alt="{{ $household?->name ?? 'Household Picture' }}"
    class="rounded-full object-cover border border-white w-{{ $size }} h-{{ $size }} {{ $class }}"
/>


