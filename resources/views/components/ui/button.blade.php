@props([
    'href' => null,
    'variant' => 'default',
    'type' => 'button',
    'full' => false,
    'size' => 'md',
])

@php
    $variantClass = match ($variant) {
        'primary' => 'primary',
        'ok' => 'ok',
        'warn' => 'warn',
        'bad' => 'bad',
        'ghost' => 'ghost',
        default => '',
    };

    $sizeClass = match ($size) {
        'sm' => 'btn-sm',
        default => '',
    };

    $classes = trim('btn '.($variantClass ? $variantClass.' ' : '').($sizeClass ? $sizeClass.' ' : '').($full ? 'btn-full' : ''));
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</button>
@endif
