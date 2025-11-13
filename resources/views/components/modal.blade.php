@props([
    'name',
    'show' => false,
    'maxWidth' => '2xl',
])

@php
    // Map kích thước modal
    $maxWidthClasses = [
        'sm' => 'sm:max-w-sm',
        'md' => 'sm:max-w-md',
        'lg' => 'sm:max-w-lg',
        'xl' => 'sm:max-w-xl',
        '2xl' => 'sm:max-w-2xl',
    ][$maxWidth] ?? 'sm:max-w-2xl';
@endphp

<div
    x-data="{
        show: @js($show),
        focusables() {
            const selector = 'a, button, input:not([type=\'hidden\']), textarea, select, details, [tabindex]:not([tabindex=\'-1\'])';
            return [...$el.querySelectorAll(selector)].filter(el => !el.hasAttribute('disabled'));
        },
        firstFocusable() { return this.focusables()[0] },
        lastFocusable() { return this.focusables().slice(-1)[0] },
        nextFocusable() { return this.focusables()[this.nextFocusableIndex()] || this.firstFocusable() },
        prevFocusable() { return this.focusables()[this.prevFocusableIndex()] || this.lastFocusable() },
        nextFocusableIndex() { return (this.focusables().indexOf(document.activeElement) + 1) % this.focusables().length },
        prevFocusableIndex() { return Math.max(0, this.focusables().indexOf(document.activeElement) - 1) },
    }"
    x-init="$watch('show', value => {
        document.body.classList.toggle('overflow-y-hidden', value);
    })"
    x-on:open-modal.window="$event.detail === '{{ $name }}' ? show = true : null"
    x-on:close-modal.window="$event.detail === '{{ $name }}' ? show = false : null"
    x-show="show"
    x-cloak
    class="fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-50"
>
    <!-- Overlay mờ nền -->
    <div
        x-show="show"
        class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        x-on:click="show = false"
    ></div>

    <!-- Modal chính -->
    <div
        x-show="show"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-10 sm:translate-y-0 sm:scale-90"
        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave-end="opacity-0 translate-y-10 sm:translate-y-0 sm:scale-90"
        class="relative bg-white rounded-2xl shadow-2xl sm:w-full {{ $maxWidthClasses }} sm:mx-auto transform transition-all"
        style="display: none;"
    >
        {{ $slot }}
    </div>
</div>
