@props(['seoTitle' => null, 'seoDescription' => null, 'seoImage' => null])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="{{ $seoDescription ?? config('seo.default_description') }}">

        <title>{{ $seoTitle ?? config('app.name', 'Laravel') }}</title>

        {{-- Open Graph (Fase 8) --}}
        <meta property="og:title" content="{{ $seoTitle ?? config('app.name') }}">
        <meta property="og:description" content="{{ $seoDescription ?? config('seo.default_description') }}">
        <meta property="og:image" content="{{ $seoImage ? (str_starts_with($seoImage, 'http') ? $seoImage : url($seoImage)) : \App\Helpers\SeoHelper::image() }}">
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ url()->current() }}">

        @include('components.analytics')

        <!-- Favicon -->
        <link rel="icon" type="image/png" href="{{ asset('logo_fri.png') }}?v=3">
        <link rel="shortcut icon" type="image/png" href="{{ asset('logo_fri.png') }}?v=3">
        <link rel="apple-touch-icon" href="{{ asset('logo_fri.png') }}?v=3">

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

        <!-- Scripts (Vite maneja dev y producción automáticamente) -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased" style="background: linear-gradient(135deg, {{ $activeTheme ? $activeTheme->background_gradient_start : '#667eea' }} 0%, {{ $activeTheme ? $activeTheme->background_gradient_mid : '#764ba2' }} 50%, {{ $activeTheme ? $activeTheme->background_gradient_end : '#f093fb' }} 100%); min-height: 100vh;">
        {{-- Navegación avanzada para páginas públicas (excepto login/register/verification) --}}
        @if(!request()->routeIs('login') && !request()->routeIs('register') && !request()->routeIs('verification.notice'))
            @include('components.advanced-navbar')
        @endif

        {{-- Menú de Perfil de Usuario (Esquina Superior Derecha) --}}
        @if(!request()->routeIs('login') && !request()->routeIs('register') && !request()->routeIs('verification.notice'))
            @include('components.user-profile-menu')
        @endif

        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0" style="padding-top: {{ request()->routeIs('login') || request()->routeIs('register') || request()->routeIs('verification.notice') ? '2rem' : '120px' }}; padding-bottom: {{ request()->routeIs('login') || request()->routeIs('register') || request()->routeIs('verification.notice') ? '2rem' : '0' }};">
            @if(request()->routeIs('login') || request()->routeIs('register') || request()->routeIs('verification.notice'))
                <div class="mb-6 sm:mb-8">
                    <a href="{{ route('home') }}" class="inline-block transition-transform hover:scale-105">
                        <div class="flex items-center gap-3">
                            <div class="logo-icon" style="width: 70px; height: 70px;">
                                @if(isset($activeLogo) && $activeLogo && $activeLogo->image_path)
                                    <img src="{{ asset($activeLogo->image_path) }}" alt="Flat Rate Imports" class="w-full h-full object-contain">
                                @else
                                    <img src="{{ asset('logo_fri.png') }}" alt="Flat Rate Imports" class="w-full h-full object-contain">
                                @endif
                            </div>
                            <span class="brand-text text-2xl sm:text-3xl">Flat Rate Imports</span>
                        </div>
                    </a>
                </div>

                <div class="w-full px-4 sm:px-0 flex justify-center">
                    {{ $slot }}
                </div>
            @else
                <div class="flex-grow w-full">
                    {{ $slot }}
                </div>
            @endif
        </div>

        {{-- Footer --}}
        @if(!request()->routeIs('login') && !request()->routeIs('register') && !request()->routeIs('verification.notice'))
            @include('components.footer')
        @endif

        {{-- Botón Flotante de Mensajería --}}
        @if(!request()->routeIs('login') && !request()->routeIs('register') && !request()->routeIs('verification.notice'))
            @include('components.messenger-float')
        @endif

        {{-- Botón Flotante de WhatsApp --}}
        @if(!request()->routeIs('login') && !request()->routeIs('register') && !request()->routeIs('verification.notice'))
            @include('components.whatsapp-float')
        @endif
        
        {{-- Widget de Chat en Vivo (Tidio o Crisp) --}}
        @if(!request()->routeIs('login') && !request()->routeIs('register') && !request()->routeIs('verification.notice'))
            @include('components.chat-widget')
        @endif
    </body>
</html>
