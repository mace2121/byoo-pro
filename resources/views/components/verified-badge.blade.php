@props([
    'label' => 'Dogrulanmis profil',
    'size' => 'md',
])

@php
    $sizeClasses = match ($size) {
        'sm' => 'h-4 w-4 text-[9px]',
        'lg' => 'h-6 w-6 text-xs',
        default => 'h-5 w-5 text-[10px]',
    };
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center justify-center rounded-full bg-sky-500 text-white shadow-sm {$sizeClasses}"]) }} title="{{ $label }}" aria-label="{{ $label }}">
    <i class="fas fa-check"></i>
</span>
