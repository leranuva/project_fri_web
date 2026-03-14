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
        {{ $styles ?? '' }}
        @stack('scripts')
    </head>
    <body class="font-sans antialiased" style="background: linear-gradient(135deg, {{ $activeTheme ? $activeTheme->background_gradient_start : '#667eea' }} 0%, {{ $activeTheme ? $activeTheme->background_gradient_mid : '#764ba2' }} 50%, {{ $activeTheme ? $activeTheme->background_gradient_end : '#f093fb' }} 100%); min-height: 100vh;">
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

        {{-- Botón Flotante de Mensajería --}}
        @include('components.messenger-float')

        {{-- Botón Flotante de WhatsApp --}}
        @include('components.whatsapp-float')
        
        {{-- Widget de Chat en Vivo (Tidio o Crisp) --}}
        @include('components.chat-widget')
    </body>
</html>
