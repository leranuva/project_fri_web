<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Favicon -->
        <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        {{-- Variables CSS del Tema Activo - DEBE IR ANTES del CSS compilado --}}
        <style>
            :root {
                --theme-text-color: {{ $activeTheme ? $activeTheme->text_color : '#ffffff' }};
                --theme-text-secondary-color: {{ $activeTheme ? $activeTheme->text_secondary_color : 'rgba(255, 255, 255, 0.8)' }};
                --theme-button-color: {{ $activeTheme ? $activeTheme->button_color : 'rgba(255, 255, 255, 0.3)' }};
            }
        </style>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased" style="background: linear-gradient(135deg, {{ $activeTheme ? $activeTheme->background_gradient_start : '#667eea' }} 0%, {{ $activeTheme ? $activeTheme->background_gradient_mid : '#764ba2' }} 50%, {{ $activeTheme ? $activeTheme->background_gradient_end : '#f093fb' }} 100%); min-height: 100vh;">
        {{-- Navegación avanzada para páginas públicas (excepto login/register) --}}
        @if(!request()->routeIs('login') && !request()->routeIs('register'))
            @include('components.advanced-navbar')
        @endif

        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0" style="padding-top: {{ request()->routeIs('login') || request()->routeIs('register') ? '2rem' : '120px' }}; padding-bottom: {{ request()->routeIs('login') || request()->routeIs('register') ? '2rem' : '0' }};">
            @if(request()->routeIs('login') || request()->routeIs('register'))
                <div class="mb-6 sm:mb-8">
                    <a href="{{ route('home') }}" class="inline-block transition-transform hover:scale-105">
                        <div class="flex items-center gap-3">
                            <div class="logo-icon" style="width: 50px; height: 50px;">
                                <svg class="w-full h-full text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                            </div>
                            <span class="brand-text text-2xl sm:text-3xl">Flat Rate Imports</span>
                        </div>
                    </a>
                </div>

                <div class="w-full px-4 sm:px-0">
                    {{ $slot }}
                </div>
            @else
                <div class="flex-grow w-full">
                    {{ $slot }}
                </div>
            @endif
        </div>

        {{-- Footer --}}
        @if(!request()->routeIs('login') && !request()->routeIs('register'))
            @include('components.footer')
        @endif

        {{-- Botón Flotante de WhatsApp --}}
        @if(!request()->routeIs('login') && !request()->routeIs('register'))
            @include('components.whatsapp-float')
        @endif
    </body>
</html>
