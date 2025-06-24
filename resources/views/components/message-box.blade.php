@props(['type' => 'success', 'message' => ''])

@php
    $colors = [
        'success' => 'green',
        'error' => 'red',
        'warning' => 'yellow',
        'info' => 'blue',
    ];
    $color = $colors[$type] ?? 'blue';
@endphp

<div class="flex items-center p-4 mb-4 text-sm text-{{ $color }}-800 bg-{{ $color }}-100 border border-{{ $color }}-300 rounded-lg shadow-sm transition-all duration-300" role="alert">
    @if ($type === 'success')
        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
            <path d="M16.707 5.293a1 1 0 010 1.414L8.414 15H7v-1.414l8.293-8.293a1 1 0 011.414 0z" />
        </svg>
    @elseif ($type === 'error')
        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v4a1 1 0 102 0V7zm-1 6a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />
        </svg>
    @elseif ($type === 'warning')
        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
            <path d="M8.257 3.099c.763-1.36 2.68-1.36 3.443 0l6.857 12.214A1.5 1.5 0 0117.214 17H2.786a1.5 1.5 0 01-1.343-2.687L8.257 3.1zM11 13a1 1 0 10-2 0 1 1 0 002 0zm-1-2a1 1 0 01-1-1V8a1 1 0 012 0v2a1 1 0 01-1 1z" />
        </svg>
    @else
        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
            <path d="M9 2a7 7 0 00-7 7 7 7 0 1014 0 7 7 0 00-7-7zM9 10a1 1 0 110 2 1 1 0 010-2zm0-6a1 1 0 00-1 1v3a1 1 0 102 0V5a1 1 0 00-1-1z" />
        </svg>
    @endif

    <span class="font-medium">{{ $message }}</span>
</div>
