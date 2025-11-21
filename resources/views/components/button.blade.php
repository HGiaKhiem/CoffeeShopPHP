@props([
    'variant' => 'primary',
    'size' => 'md',
    'icon' => null,
    'type' => 'button',
    'href' => null,
])

@php
    $classes = "cs-btn cs-btn-{$variant} cs-btn-{$size}";
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if($icon)
            <span class="cs-btn-icon">{!! $icon !!}</span>
        @endif
        <span class="cs-btn-label">{{ $slot }}</span>
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if($icon)
            <span class="cs-btn-icon">{!! $icon !!}</span>
        @endif
        <span class="cs-btn-label">{{ $slot }}</span>
    </button>
@endif
