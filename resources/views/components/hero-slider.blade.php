{{-- Hero Slider Component --}}
@php
    // Obtener sliders activos ordenados, o usar datos por defecto si no hay sliders
    $sliders = $sliders ?? \App\Models\Slider::active()->ordered()->get();
    
    // Si no hay sliders, usar datos por defecto (los 4 slides originales)
    if ($sliders->isEmpty()) {
        $sliders = collect([
            (object)[
                'id' => 1,
                'title' => 'Dirección de Casillero Postal GRATIS',
                'subtitle' => 'Te ofrecemos una dirección de casillero postal en USA totalmente GRATIS al registrarte',
                'description' => 'Compra en tu tienda online favorita, envía al casillero y nosotros lo importaremos hasta entregar en tus manos.',
                'image' => 'https://images.unsplash.com/photo-1566576912321-58a32b37819a?w=1200&h=600&fit=crop',
                'cta' => 'Registrarse Gratis',
                'cta_link' => route('register'),
                'title_color' => '#ffffff',
                'subtitle_color' => '#ffffff'
            ],
            (object)[
                'id' => 2,
                'title' => 'Proceso Fácil y Rápido',
                'subtitle' => 'El proceso es fácil: compras, alertas en tu panel, recibimos en la casilla, importamos',
                'description' => 'Gestiona todo desde tu panel de usuario. Recibe alertas cuando llegue tu paquete y sigue el proceso en tiempo real.',
                'image' => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=1200&h=600&fit=crop',
                'cta' => 'Ver Cómo Funciona',
                'cta_link' => '#como-funciona',
                'title_color' => '#ffffff',
                'subtitle_color' => '#ffffff'
            ],
            (object)[
                'id' => 3,
                'title' => 'Más de 10 Años de Experiencia',
                'subtitle' => 'Seguridad y rapidez en tus entregas',
                'description' => 'Flat Rate Imports tiene más de 10 años en el mercado, ofreciendo seguridad y rapidez en tus entregas con la confianza que necesitas.',
                'image' => 'https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?w=1200&h=600&fit=crop',
                'cta' => 'Conocer Más',
                'cta_link' => '#beneficios',
                'title_color' => '#ffffff',
                'subtitle_color' => '#ffffff'
            ],
            (object)[
                'id' => 4,
                'title' => 'Seguimiento de Paquetes en Tiempo Real',
                'subtitle' => 'Rastrea tus envíos desde cualquier lugar',
                'description' => 'Con nuestro sistema de tracking, podrás seguir el estado de tu paquete en cada etapa del proceso de importación.',
                'image' => 'https://images.unsplash.com/photo-1579621970563-ebec7560ff3e?w=1200&h=600&fit=crop',
                'cta' => 'Rastrear Paquete',
                'cta_link' => '#tracking',
                'title_color' => '#ffffff',
                'subtitle_color' => '#ffffff'
            ]
        ]);
    }
@endphp

<div 
    x-data="{ 
        currentSlide: 0,
        autoPlayInterval: null,
        slides: @js($sliders->map(function($slider) {
            return [
                'id' => $slider->id,
                'title' => $slider->title,
                'subtitle' => $slider->subtitle ?? '',
                'description' => $slider->description ?? '',
                'image' => $slider->image,
                'cta' => $slider->cta ?? '',
                'ctaLink' => $slider->cta_link ?? '#',
                'titleColor' => $slider->title_color ?? '#ffffff',
                'subtitleColor' => $slider->subtitle_color ?? '#ffffff'
            ];
        })->values()->all()),
        nextSlide() {
            this.currentSlide = (this.currentSlide + 1) % this.slides.length;
        },
        prevSlide() {
            this.currentSlide = (this.currentSlide - 1 + this.slides.length) % this.slides.length;
        },
        goToSlide(index) {
            this.currentSlide = index;
        },
        startAutoPlay() {
            this.autoPlayInterval = setInterval(() => {
                this.nextSlide();
            }, 5000);
        },
        stopAutoPlay() {
            if (this.autoPlayInterval) {
                clearInterval(this.autoPlayInterval);
                this.autoPlayInterval = null;
            }
        }
    }"
    x-init="startAutoPlay()"
    @mouseenter="stopAutoPlay()"
    @mouseleave="startAutoPlay()"
    class="hero-slider relative w-screen overflow-hidden"
    style="height: 70vh; margin-left: calc(-50vw + 50%); margin-right: calc(-50vw + 50%);"
    @keydown.left.window="prevSlide()"
    @keydown.right.window="nextSlide()"
>
    {{-- Slides --}}
    <div class="relative w-full h-full">
        <template x-for="(slide, index) in slides" :key="slide.id">
            <div 
                x-show="currentSlide === index"
                x-transition:enter="transition ease-out duration-500"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-500"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="absolute inset-0 w-full h-full"
            >
                {{-- Background Image --}}
                <div class="absolute inset-0 z-0">
                    <img 
                        :src="slide.image" 
                        :alt="slide.title"
                        class="w-full h-full object-cover"
                    >
                </div>

                {{-- Content Overlay --}}
                <div class="relative z-[1] h-full flex items-center">
                    <x-ui.container>
                        <div class="text-center text-white max-w-4xl mx-auto px-4">
                            <h1 
                                x-text="slide.title"
                                :style="'color: ' + (slide.titleColor || '#ffffff')"
                                class="text-3xl sm:text-4xl lg:text-5xl xl:text-6xl font-bold mb-4 sm:mb-6 leading-tight drop-shadow-lg"
                            ></h1>
                            <p 
                                x-text="slide.subtitle"
                                :style="'color: ' + (slide.subtitleColor || '#ffffff')"
                                class="text-lg sm:text-xl lg:text-2xl mb-4 sm:mb-6 drop-shadow-md"
                            ></p>
                            <p 
                                x-text="slide.description"
                                class="text-base sm:text-lg mb-8 sm:mb-10 text-white/90 max-w-2xl mx-auto drop-shadow-sm"
                            ></p>
                            <template x-if="slide.cta">
                                <div>
                                    <a 
                                        :href="slide.ctaLink"
                                        class="hero-slider-cta-button"
                                    >
                                        <span x-text="slide.cta"></span>
                                    </a>
                                </div>
                            </template>
                        </div>
                    </x-ui.container>
                </div>
            </div>
        </template>
    </div>

    {{-- Navigation Arrows --}}
    <button 
        @click="prevSlide()"
        class="hero-slider-nav-button hero-slider-nav-prev"
        aria-label="Slide anterior"
    >
        <svg class="hero-slider-nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
    </button>
    
    <button 
        @click="nextSlide()"
        class="hero-slider-nav-button hero-slider-nav-next"
        aria-label="Slide siguiente"
    >
        <svg class="hero-slider-nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
        </svg>
    </button>

    {{-- Slide Indicators --}}
    <div class="hero-slider-indicators">
        <template x-for="(slide, index) in slides" :key="slide.id">
            <button 
                @click="goToSlide(index)"
                :class="currentSlide === index ? 'hero-slider-indicator-active' : 'hero-slider-indicator'"
                :aria-label="'Ir al slide ' + (index + 1)"
            ></button>
        </template>
    </div>

    {{-- Auto-play indicator (optional) --}}
    <div class="hero-slider-counter">
        <span x-text="(currentSlide + 1) + ' / ' + slides.length"></span>
    </div>
</div>

