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
        <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('brand/fri-icon.png') }}">
        <link rel="apple-touch-icon" sizes="192x192" href="{{ asset('brand/fri-icon.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <x-theme-variables />

        <!-- Scripts (Vite maneja dev y producción automáticamente) -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased theme-page" data-theme-legacy>
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
                            <div class="logo-icon" style="--brand-logo-size: 70px;">
                                <x-brand-logo alt="Flat Rate Imports" class="w-full h-full object-contain" />
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

        @unless(request()->routeIs('login', 'register', 'verification.notice'))
            <div @class(['public-contact-actions' => request()->routeIs('home', 'cotizador')])>
                @include('components.messenger-float')
                @include('components.whatsapp-float')
            </div>
        @endunless

        {{-- Widget de Chat en Vivo (Tidio o Crisp) --}}
        @if(!request()->routeIs('login') && !request()->routeIs('register') && !request()->routeIs('verification.notice'))
            @include('components.chat-widget')
        @endif
    </body>
</html>
