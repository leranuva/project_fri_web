@php
    $colorGradients = [
        'blue' => 'from-blue-500/30 to-blue-600/20',
        'green' => 'from-green-500/30 to-green-600/20',
        'red' => 'from-red-500/30 to-red-600/20',
        'yellow' => 'from-yellow-500/30 to-yellow-600/20',
        'purple' => 'from-purple-500/30 to-purple-600/20',
    ];
    
    $iconColors = [
        'blue' => 'text-blue-300',
        'green' => 'text-green-300',
        'red' => 'text-red-300',
        'yellow' => 'text-yellow-300',
        'purple' => 'text-purple-300',
    ];
@endphp

<x-ui.card glassmorphism="true" padding="default" class="dashboard-stat-card hover:scale-105 transition-all duration-300">
    <div class="flex items-center justify-between">
        <div class="flex-1">
            <p class="text-sm sm:text-base font-medium text-white/70 mb-2">{{ $title }}</p>
            <p class="text-2xl sm:text-3xl font-bold text-white">{{ $value }}</p>
        </div>
        @if($icon)
            <div class="ml-4 p-3 sm:p-4 rounded-xl bg-gradient-to-br {{ $colorGradients[$color] }} backdrop-blur-sm border border-white/20">
                @if(str_contains($icon, 'fa-'))
                    <i class="{{ $icon }} {{ $iconColors[$color] }} text-xl sm:text-2xl"></i>
                @else
                    {{-- Fallback SVG icons --}}
                    @if(str_contains($icon, 'users') || str_contains($icon, 'user'))
                        <svg class="w-6 h-6 {{ $iconColors[$color] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    @elseif(str_contains($icon, 'box') || str_contains($icon, 'package'))
                        <svg class="w-6 h-6 {{ $iconColors[$color] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    @elseif(str_contains($icon, 'dollar') || str_contains($icon, 'money'))
                        <svg class="w-6 h-6 {{ $iconColors[$color] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    @elseif(str_contains($icon, 'cart') || str_contains($icon, 'shopping'))
                        <svg class="w-6 h-6 {{ $iconColors[$color] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    @elseif(str_contains($icon, 'shield'))
                        <svg class="w-6 h-6 {{ $iconColors[$color] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    @else
                        <i class="{{ $icon }} {{ $iconColors[$color] }} text-xl sm:text-2xl"></i>
                    @endif
                @endif
            </div>
        @endif
    </div>
</x-ui.card>
