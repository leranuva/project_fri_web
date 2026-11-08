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
        <meta property="og:image" content="{{ $seoImage ?? \App\Helpers\SeoHelper::image() }}">
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
        {{ $styles ?? '' }}
        @stack('scripts')
    </head>
    <body class="font-sans antialiased theme-page" data-theme-legacy>
        {{-- Navegación avanzada --}}
        @include('components.advanced-navbar')
        
        {{-- Menú de Perfil de Usuario (Esquina Superior Derecha) --}}
        @include('components.user-profile-menu')

        <div class="min-h-screen flex flex-col bg-transparent">
            {{-- Contenido Principal --}}
            <div class="flex-grow flex flex-col min-w-0" style="padding-top: 120px;">
                {{-- Page Heading --}}
                @isset($header)
                    <header class="bg-white bg-opacity-10 backdrop-filter backdrop-blur-lg shadow-lg border-b border-white border-opacity-20">
                        <x-ui.container>
                            <div class="py-4 sm:py-6">
                                {{ $header }}
                            </div>
                        </x-ui.container>
                    </header>
                @endisset

                {{-- Page Content --}}
                <main class="flex-grow py-4 sm:py-6 lg:py-8">
                    <x-ui.container>
                        {{ $slot }}
                    </x-ui.container>
                </main>
            </div>

            {{-- Footer --}}
            @include('components.footer')
        </div>

        <div @class(['public-contact-actions' => request()->routeIs('home', 'cotizador')])>
            @include('components.messenger-float')
            @include('components.whatsapp-float')
        </div>

        {{-- Widget de Chat en Vivo (Tidio o Crisp) --}}
        @include('components.chat-widget')
    </body>
</html>
