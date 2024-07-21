@php
$id = $id ?? md5($attributes->wire('model'));

$maxWidth = [
    'sm:sm' => 'sm:max-w-sm',
    'sm:md' => 'sm:max-w-md',
    'sm:lg' => 'sm:max-w-lg',
    'sm:xl' => 'sm:max-w-xl',
    'sm:2xl' => 'sm:max-w-2xl',
    'sm:full' => 'sm:max-w-full',
    'md:sm' => 'md:max-w-sm',
    'md:md' => 'md:max-w-md',
    'md:lg' => 'md:max-w-lg',
    'md:xl' => 'md:max-w-xl',
    'md:2xl' => 'md:max-w-2xl',
    'md:full' => 'md:max-w-full',
    'lg:sm' => 'lg:max-w-sm',
    'lg:md' => 'lg:max-w-md',
    'lg:lg' => 'lg:max-w-lg',
    'lg:xl' => 'lg:max-w-xl',
    'lg:2xl' => 'lg:max-w-2xl',
    'lg:full' => 'lg:max-w-full',
    'sm' => 'max-w-sm',
    'md' => 'max-w-md',
    'lg' => 'max-w-lg',
    'xl' => 'max-w-xl',
    '2xl' => 'max-w-2xl',
    'full' => 'max-w-full',
][$maxWidth ?? '2xl'];
@endphp


<div
    x-data="{ show: @entangle($attributes->wire('model')) }"
    x-on:close.stop="show = false"
    x-on:keydown.escape.window="show = false"
    x-show="show"
    id="{{ $id }}"
    class="jetstream-modal fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-50"
    style="display: none;"
>
    <div x-show="show" class="fixed inset-0 transform transition-all" x-on:click="show = false" x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
    </div>

    <div x-show="show" class="mb-6 bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full {{ $maxWidthClass }} sm:mx-auto {!! $attributes['class'] !!}"
         x-trap.inert.noscroll="show"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
         x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
        <div class="px-6 py-4">
            <div class="text-lg">
                {{ $title }}
            </div>
            <div class="mt-4">
                {{ $content }}
            </div>
        </div>

        <div class="px-6 py-4 bg-gray-100 text-right">
            {{ $footer }}
        </div>
    </div>
</div>
