<x-guest-layout>
    <div class="min-h-screen flex flex-col" style="padding-top: 0;">
        {{-- Hero Section con Slider --}}
        <section class="text-white" style="background: transparent; padding-top: 0; padding-bottom: 0;">
            {{-- Hero Slider --}}
            <div class="mb-8 sm:mb-12">
                <x-hero-slider :sliders="$sliders" />
            </div>
            
            <x-ui.container>
                
                    {{-- Tracking Widget --}}
                    <div id="tracking" class="max-w-2xl mx-auto mb-8">
                        <x-ui.card glassmorphism="true" padding="default" class="tracking-widget">
                            <h3 class="text-xl font-semibold mb-4 text-white">Seguimiento de Paquetes</h3>
                            <form action="{{ route('tracking.search') }}" method="POST" class="flex flex-col sm:flex-row gap-3">
                                @csrf
                                <input 
                                    type="text" 
                                    name="tracking_number"
                                    value="{{ old('tracking_number') }}"
                                    placeholder="Código de tracking o guía" 
                                    class="flex-1 auth-form-input @error('tracking_number') border-red-500 @enderror"
                                    required
                                >
                                <button type="submit" class="glass-button glass-button-sm sm:w-auto">
                                    Buscar información
                                </button>
                            </form>
                            @error('tracking_number')
                                <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                            @enderror
                            @if(session('tracking_error'))
                                <p class="text-red-400 text-sm mt-2">{{ session('tracking_error') }}</p>
                            @endif
                        </x-ui.card>
                    </div>

                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a 
                        href="{{ route('register') }}"
                        class="glass-button glass-button-lg glass-button-full"
                    >
                        Registrarse Gratis
                    </a>
                    <a 
                        href="{{ route('cotizador') }}"
                        class="glass-button glass-button-lg glass-button-full"
                    >
                        Cotizar Ahora
                    </a>
                </div>
            </x-ui.container>
        </section>

        {{-- Sección: ¿Cómo Funciona? --}}
        <section id="como-funciona" class="py-12 sm:py-16 lg:py-20" style="background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(10px);">
            <x-ui.container>
                <div class="text-center mb-12">
                    <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold mb-4 text-white">
                        {{ $processSection->title ?? '¿CÓMO FUNCIONA FLAT RATE IMPORTS?' }}
                    </h2>
                    @if($processSection && $processSection->subtitle)
                        <p class="text-lg sm:text-xl text-white/80 max-w-3xl mx-auto">
                            {{ $processSection->subtitle }}
                        </p>
                    @else
                        <p class="text-lg sm:text-xl text-white/80 max-w-3xl mx-auto">
                            El proceso es fácil: compras, alertas en tu panel de usuario, recibimos en la casilla, importamos.
                        </p>
                    @endif
                </div>

                <x-ui.grid :cols="1" :cols-sm="2" :cols-md="4" gap="default">
                    @forelse($processSteps as $step)
                        <x-ui.card glassmorphism="true" class="text-center process-step">
                            <div class="mb-4">
                                <div class="w-16 h-16 mx-auto bg-white/20 rounded-full flex items-center justify-center mb-4">
                                    <span class="text-2xl font-bold text-white">{{ $step->step_number }}</span>
                                </div>
                                <div class="flex items-center justify-center">
                                    {!! $step->icon_svg !!}
                                </div>
                            </div>
                            <h3 class="text-xl font-semibold mb-2 text-white">{{ $step->title }}</h3>
                            <p class="text-white/80 text-sm sm:text-base">
                                {{ $step->description }}
                            </p>
                        </x-ui.card>
                    @empty
                        {{-- Datos por defecto si no hay pasos en la BD --}}
                        <x-ui.card glassmorphism="true" class="text-center process-step">
                            <div class="mb-4">
                                <div class="w-16 h-16 mx-auto bg-white/20 rounded-full flex items-center justify-center mb-4">
                                    <span class="text-2xl font-bold text-white">1</span>
                                </div>
                                <svg class="w-12 h-12 mx-auto text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold mb-2 text-white">Compras</h3>
                            <p class="text-white/80 text-sm sm:text-base">
                                Compra en tu tienda online favorita y envía al casillero
                            </p>
                        </x-ui.card>
                        <x-ui.card glassmorphism="true" class="text-center process-step">
                            <div class="mb-4">
                                <div class="w-16 h-16 mx-auto bg-white/20 rounded-full flex items-center justify-center mb-4">
                                    <span class="text-2xl font-bold text-white">2</span>
                                </div>
                                <svg class="w-12 h-12 mx-auto text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold mb-2 text-white">Alertas</h3>
                            <p class="text-white/80 text-sm sm:text-base">
                                Recibe alertas en tu panel de usuario cuando llegue tu paquete
                            </p>
                        </x-ui.card>
                        <x-ui.card glassmorphism="true" class="text-center process-step">
                            <div class="mb-4">
                                <div class="w-16 h-16 mx-auto bg-white/20 rounded-full flex items-center justify-center mb-4">
                                    <span class="text-2xl font-bold text-white">3</span>
                                </div>
                                <svg class="w-12 h-12 mx-auto text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold mb-2 text-white">Recibimos</h3>
                            <p class="text-white/80 text-sm sm:text-base">
                                Recibimos tu paquete en nuestra casilla postal en USA
                            </p>
                        </x-ui.card>
                        <x-ui.card glassmorphism="true" class="text-center process-step">
                            <div class="mb-4">
                                <div class="w-16 h-16 mx-auto bg-white/20 rounded-full flex items-center justify-center mb-4">
                                    <span class="text-2xl font-bold text-white">4</span>
                                </div>
                                <svg class="w-12 h-12 mx-auto text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold mb-2 text-white">Importamos</h3>
                            <p class="text-white/80 text-sm sm:text-base">
                                Importamos y entregamos hasta tus manos de forma segura
                            </p>
                        </x-ui.card>
                    @endforelse
                </x-ui.grid>

                <div class="text-center mt-12">
                    @if($processSection && $processSection->footer_text)
                        <p class="text-white/90 text-lg mb-6">
                            {!! nl2br(e($processSection->footer_text)) !!}
                        </p>
                    @else
                        <p class="text-white/90 text-lg mb-6">
                            <strong class="text-white">FLAT RATE IMPORTS</strong> tiene más de 10 años en el mercado, ofreciendo seguridad y rapidez en tus entregas.
                        </p>
                    @endif
                    @if($processSection && $processSection->button_text && $processSection->button_link)
                        <a 
                            href="{{ $processSection->button_link }}"
                            class="glass-button glass-button-lg"
                        >
                            {{ $processSection->button_text }}
                        </a>
                    @else
                        <a 
                            href="{{ route('cotizador') }}"
                            class="glass-button glass-button-lg"
                        >
                            Más Información
                        </a>
                    @endif
                </div>
            </x-ui.container>
        </section>

        {{-- Sección: Alerta de Compra --}}
        @if($alertBanner)
            <section class="py-12 sm:py-16 lg:py-20" style="background: transparent;">
                <x-ui.container>
                    <x-ui.card 
                        glassmorphism="true" 
                        padding="lg" 
                        class="alert-section"
                        style="background: {{ $alertBanner->container_color ?? 'rgba(255, 255, 255, 0.15)' }} !important; {{ $alertBanner->background_color && $alertBanner->background_color !== 'transparent' ? 'background-color: ' . $alertBanner->background_color . ';' : '' }}"
                    >
                        <div class="text-center">
                            <div class="mb-6">
                                <div class="flex items-center justify-center">
                                    {!! $alertBanner->icon_svg !!}
                                </div>
                            </div>
                            <h2 
                                class="text-2xl sm:text-3xl lg:text-4xl font-bold mb-4"
                                style="color: {{ $alertBanner->title_color ?? '#ffffff' }};"
                            >
                                {{ $alertBanner->title }}
                            </h2>
                            <p 
                                class="text-lg sm:text-xl mb-8 max-w-2xl mx-auto"
                                style="color: {{ $alertBanner->description_color ?? '#ffffff' }};"
                            >
                                {{ $alertBanner->description }}
                            </p>
                            @auth
                                @if($alertBanner->button_text_auth && $alertBanner->button_link_auth)
                                    <a 
                                        href="{{ $alertBanner->button_link_auth }}"
                                        class="glass-button glass-button-lg"
                                    >
                                        {{ $alertBanner->button_text_auth }}
                                    </a>
                                @endif
                            @else
                                @if($alertBanner->button_text_guest && $alertBanner->button_link_guest)
                                    <a 
                                        href="{{ $alertBanner->button_link_guest }}"
                                        class="glass-button glass-button-lg"
                                    >
                                        {{ $alertBanner->button_text_guest }}
                                    </a>
                                @endif
                            @endauth
                        </div>
                    </x-ui.card>
                </x-ui.container>
            </section>
        @else
            {{-- Fallback si no hay banner activo --}}
            <section class="py-12 sm:py-16 lg:py-20" style="background: transparent;">
                <x-ui.container>
                    <x-ui.card glassmorphism="true" padding="lg" class="alert-section">
                        <div class="text-center">
                            <div class="mb-6">
                                <svg class="w-16 h-16 mx-auto text-yellow-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                            </div>
                            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold mb-4 text-white">
                                ¡NO OLVIDES ALERTAR TU COMPRA!
                            </h2>
                            <p class="text-lg sm:text-xl text-white/90 mb-8 max-w-2xl mx-auto">
                                Alertar la compra evitará retrasos en la importación y permitirá identificar el paquete con facilidad.
                            </p>
                            @auth
                                <a 
                                    href="{{ route('dashboard') }}"
                                    class="glass-button glass-button-lg"
                                >
                                    Alertar Compra
                                </a>
                            @else
                                <a 
                                    href="{{ route('register') }}"
                                    class="glass-button glass-button-lg"
                                >
                                    Registrarse para Alertar
                                </a>
                            @endauth
                        </div>
                    </x-ui.card>
                </x-ui.container>
            </section>
        @endif

        {{-- Sección: Beneficios --}}
        <section id="beneficios" class="py-12 sm:py-16 lg:py-20" style="background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(10px);">
            <x-ui.container>
                <h2 
                    class="text-3xl sm:text-4xl font-bold text-center mb-12"
                    style="color: {{ $benefitSection && $benefitSection->is_active && $benefitSection->title_color ? $benefitSection->title_color : '#ffffff' }};"
                >
                    {{ $benefitSection && $benefitSection->is_active ? $benefitSection->title : '¿Por qué elegir Flat Rate Imports?' }}
                </h2>
                <x-ui.grid :cols="1" :cols-sm="2" :cols-md="3" gap="default">
                    @forelse($benefits as $benefit)
                        <x-ui.card glassmorphism="true" class="text-center benefit-card">
                            <div class="mb-4">
                                <div class="flex items-center justify-center">
                                    {!! $benefit->icon_svg !!}
                                </div>
                            </div>
                            <h3 
                                class="text-xl font-semibold mb-2"
                                style="color: {{ $benefit->title_color ?? '#ffffff' }};"
                            >
                                {{ $benefit->title }}
                            </h3>
                            <p 
                                class="text-sm sm:text-base"
                                style="color: {{ $benefit->description_color ?? 'rgba(255, 255, 255, 0.8)' }};"
                            >
                                {{ $benefit->description }}
                            </p>
                        </x-ui.card>
                    @empty
                        {{-- Datos por defecto si no hay beneficios en la BD --}}
                        <x-ui.card glassmorphism="true" class="text-center benefit-card">
                            <div class="mb-4">
                                <svg class="w-12 h-12 mx-auto text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold mb-2 text-white">Dirección GRATIS</h3>
                            <p class="text-white/80 text-sm sm:text-base">
                                Obtén una dirección de casillero postal en USA totalmente gratis al registrarte
                            </p>
                        </x-ui.card>
                        <x-ui.card glassmorphism="true" class="text-center benefit-card">
                            <div class="mb-4">
                                <svg class="w-12 h-12 mx-auto text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold mb-2 text-white">Seguridad</h3>
                            <p class="text-white/80 text-sm sm:text-base">
                                Más de 10 años de experiencia garantizando la seguridad de tus envíos
                            </p>
                        </x-ui.card>
                        <x-ui.card glassmorphism="true" class="text-center benefit-card">
                            <div class="mb-4">
                                <svg class="w-12 h-12 mx-auto text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold mb-2 text-white">Rapidez</h3>
                            <p class="text-white/80 text-sm sm:text-base">
                                Procesos optimizados para entregas rápidas y eficientes
                            </p>
                        </x-ui.card>
                        <x-ui.card glassmorphism="true" class="text-center benefit-card">
                            <div class="mb-4">
                                <svg class="w-12 h-12 mx-auto text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold mb-2 text-white">Precios Competitivos</h3>
                            <p class="text-white/80 text-sm sm:text-base">
                                Los mejores precios del mercado para tus importaciones
                            </p>
                        </x-ui.card>
                        <x-ui.card glassmorphism="true" class="text-center benefit-card">
                            <div class="mb-4">
                                <svg class="w-12 h-12 mx-auto text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold mb-2 text-white">Panel de Usuario</h3>
                            <p class="text-white/80 text-sm sm:text-base">
                                Gestiona tus compras, alertas y seguimiento desde un solo lugar
                            </p>
                        </x-ui.card>
                        <x-ui.card glassmorphism="true" class="text-center benefit-card">
                            <div class="mb-4">
                                <svg class="w-12 h-12 mx-auto text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold mb-2 text-white">Soporte 24/7</h3>
                            <p class="text-white/80 text-sm sm:text-base">
                                Atención al cliente disponible cuando la necesites
                            </p>
                        </x-ui.card>
                    @endforelse
                </x-ui.grid>
            </x-ui.container>
        </section>

        {{-- Sección: Tiendas --}}
        @if($storeSection && $storeSection->is_active)
            <section class="py-12 sm:py-16 lg:py-20" style="background: transparent;">
                <x-ui.container>
                    <h2 
                        class="text-3xl sm:text-4xl font-bold text-center mb-4"
                        style="color: {{ $storeSection->title_color ?? '#ffffff' }};"
                    >
                        {{ $storeSection->title }}
                    </h2>
                    @if($storeSection->subtitle)
                        <p 
                            class="text-center mb-12 text-lg"
                            style="color: {{ $storeSection->subtitle_color ?? 'rgba(255, 255, 255, 0.8)' }};"
                        >
                            {{ $storeSection->subtitle }}
                        </p>
                    @endif
                    
                    <x-ui.card glassmorphism="true" padding="lg" class="stores-section">
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6">
                            @forelse($stores as $store)
                                <div class="store-logo">
                                    @if($store->logo_url)
                                        <a 
                                            href="{{ $store->website_url ?? '#' }}" 
                                            target="{{ $store->website_url ? '_blank' : '_self' }}"
                                            class="block w-full h-20 bg-white/10 rounded-lg flex items-center justify-center border border-white/20 hover:bg-white/20 transition-colors p-2"
                                        >
                                            <div class="max-w-full max-h-full flex items-center justify-center">
                                                {!! $store->logo_url !!}
                                            </div>
                                        </a>
                                    @else
                                        <div class="w-full h-20 bg-white/10 rounded-lg flex items-center justify-center border border-white/20">
                                            <span class="text-white/60 text-xs font-semibold text-center px-2">{{ $store->name }}</span>
                                        </div>
                                    @endif
                                </div>
                            @empty
                                {{-- Fallback si no hay tiendas --}}
                                @for($i = 1; $i <= 12; $i++)
                                    <div class="store-logo">
                                        <div class="w-full h-20 bg-white/10 rounded-lg flex items-center justify-center border border-white/20">
                                            <span class="text-white/60 text-xs font-semibold">Tienda {{ $i }}</span>
                                        </div>
                                    </div>
                                @endfor
                            @endforelse
                        </div>
                        @if($storeSection->footer_link && $storeSection->footer_link_text)
                            <div class="text-center mt-8">
                                <a href="{{ $storeSection->footer_link }}" target="_blank" class="auth-form-link text-lg">
                                    {{ $storeSection->footer_link_text }} →
                                </a>
                            </div>
                        @endif
                    </x-ui.card>
                </x-ui.container>
            </section>
        @endif

        {{-- Sección: Temas de Interés / Blog --}}
        @if($blogSection && $blogSection->is_active)
            <section class="py-12 sm:py-16 lg:py-20" style="background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(10px);">
                <x-ui.container>
                    <h2 
                        class="text-3xl sm:text-4xl font-bold text-center mb-12"
                        style="color: {{ $blogSection->title_color ?? '#ffffff' }};"
                    >
                        {{ $blogSection->title }}
                    </h2>
                    
                    <x-ui.grid :cols="1" :cols-sm="2" :cols-md="3" gap="default">
                        @forelse($blogPosts as $post)
                            <x-ui.card glassmorphism="true" class="blog-card cursor-pointer hover:scale-105 transition-transform">
                                <div class="mb-4">
                                    @if($post->featured_image_url)
                                        <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}" class="w-full h-48 object-cover rounded-lg mb-4">
                                    @else
                                        <div class="w-full h-48 bg-white/10 rounded-lg mb-4"></div>
                                    @endif
                                    <h3 class="text-xl font-semibold mb-2 text-white">
                                        {{ $post->title }}
                                    </h3>
                                    @if($post->excerpt)
                                        <p class="text-white/80 text-sm mb-4">
                                            {{ $post->excerpt }}
                                        </p>
                                    @endif
                                    @if($post->link)
                                        <a href="{{ $post->link }}" target="_blank" class="auth-form-link text-sm font-semibold">
                                            Leer más →
                                        </a>
                                    @else
                                        <a href="#" class="auth-form-link text-sm font-semibold">
                                            Leer más →
                                        </a>
                                    @endif
                                </div>
                            </x-ui.card>
                        @empty
                            {{-- Fallback si no hay artículos --}}
                            @for($i = 1; $i <= 3; $i++)
                                <x-ui.card glassmorphism="true" class="blog-card cursor-pointer hover:scale-105 transition-transform">
                                    <div class="mb-4">
                                        <div class="w-full h-48 bg-white/10 rounded-lg mb-4"></div>
                                        <h3 class="text-xl font-semibold mb-2 text-white">
                                            Título del Artículo {{ $i }}
                                        </h3>
                                        <p class="text-white/80 text-sm mb-4">
                                            Descripción breve del artículo que será de interés para los usuarios...
                                        </p>
                                        <a href="#" class="auth-form-link text-sm font-semibold">
                                            Leer más →
                                        </a>
                                    </div>
                                </x-ui.card>
                            @endfor
                        @endforelse
                    </x-ui.grid>

                    @if($blogSection->button_text && $blogSection->button_link)
                        <div class="text-center mt-12">
                            <a 
                                href="{{ $blogSection->button_link }}"
                                class="glass-button glass-button-lg"
                            >
                                {{ $blogSection->button_text }}
                            </a>
                        </div>
                    @endif
                </x-ui.container>
            </section>
        @endif

        {{-- CTA Final --}}
        <section class="py-12 sm:py-16 lg:py-20" style="background: transparent;">
            <x-ui.container>
                <x-ui.card glassmorphism="true" padding="lg" class="text-center final-cta">
                    <h2 class="text-3xl sm:text-4xl font-bold mb-4 text-white">
                        ¿Listo para comenzar?
                    </h2>
                    <p class="text-lg sm:text-xl text-white/80 mb-8 max-w-2xl mx-auto">
                        Regístrate ahora y obtén tu dirección de casillero postal en USA totalmente gratis
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        @auth
                            <a 
                                href="{{ route('dashboard') }}"
                                class="glass-button glass-button-lg glass-button-full"
                            >
                                Ir al Dashboard
                            </a>
                        @else
                            <a 
                                href="{{ route('register') }}"
                                class="glass-button glass-button-lg glass-button-full"
                            >
                                Registrarse Gratis
                            </a>
                            <a 
                                href="{{ route('login') }}"
                                class="glass-button glass-button-lg glass-button-full"
                            >
                                Iniciar Sesión
                            </a>
                        @endauth
                    </div>
                </x-ui.card>
            </x-ui.container>
        </section>
    </div>
</x-guest-layout>
