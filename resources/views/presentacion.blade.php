<x-guest-layout :seoTitle="'Presentación del Proyecto | ' . config('app.name')" :seoDescription="'Conoce Flat Rate Imports: la plataforma de importación desde USA a Ecuador para particulares y emprendedores.'">
    <style>
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(24px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes fadeInLeft { from { opacity: 0; transform: translateX(24px); } to { opacity: 1; transform: translateX(0); } }
        .animate-fade-in-up { animation: fadeInUp 0.6s ease-out forwards; }
        .animate-fade-in-left { animation: fadeInLeft 0.5s ease-out forwards; }
        .delay-0 { animation-delay: 0ms; } .delay-75 { animation-delay: 75ms; } .delay-100 { animation-delay: 100ms; }
        .delay-150 { animation-delay: 150ms; } .delay-200 { animation-delay: 200ms; } .delay-300 { animation-delay: 300ms; }
        .delay-400 { animation-delay: 400ms; } .delay-500 { animation-delay: 500ms; }
    </style>
    <div class="min-h-screen flex flex-col" style="padding-top: 0;">
        
        {{-- Hero de Presentación --}}
        <section class="py-16 sm:py-24 lg:py-32 text-white relative overflow-hidden">
            <div class="absolute inset-0 bg-black/20"></div>
            <x-ui.container class="relative z-10">
                <div class="text-center max-w-4xl mx-auto opacity-0 animate-fade-in-up">
                    <p class="text-white/80 text-sm sm:text-base uppercase tracking-widest mb-4">Presentación para cliente</p>
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold mb-6 leading-tight">
                        Flat Rate Imports
                    </h1>
                    <p class="text-xl sm:text-2xl text-white/90 mb-8">
                        La plataforma que conecta a Ecuador con las mejores tiendas de Estados Unidos
                    </p>
                    <a href="{{ route('home') }}" class="glass-button glass-button-lg inline-flex items-center gap-2">
                        Conocer el sitio
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </a>
                </div>
            </x-ui.container>
        </section>

        {{-- ¿Qué hace este proyecto? --}}
        <section class="py-16 sm:py-20" style="background: rgba(255, 255, 255, 0.08); backdrop-filter: blur(12px);">
            <x-ui.container>
                <div class="text-center mb-16 opacity-0 animate-fade-in-up delay-100">
                    <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-white mb-6">
                        ¿Qué hace este proyecto?
                    </h2>
                    <p class="text-lg sm:text-xl text-white/85 max-w-3xl mx-auto">
                        Flat Rate Imports es una plataforma web que permite a los usuarios <strong class="text-white">comprar productos en tiendas de Estados Unidos</strong> y recibirlos en Ecuador. 
                        Ofrece una dirección de casillero postal en USA gratuita, cotización de envíos en tiempo real, seguimiento de paquetes y una tienda propia con productos seleccionados.
                    </p>
                </div>

                <x-ui.grid :cols="1" :cols-sm="2" :cols-md="3" gap="default">
                    @php
                        $features = [
                            ['icon' => 'M16 11V7a4 4 0 0 0-8 0v4M5 9h14l1 12H4L5 9z', 'title' => 'Casillero gratuito', 'desc' => 'Dirección en USA para recibir tus compras'],
                            ['icon' => 'M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z', 'title' => 'Cotizador en vivo', 'desc' => 'Calcula costos de envío antes de comprar'],
                            ['icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4', 'title' => 'Tracking de paquetes', 'desc' => 'Sigue tu envío en cada etapa del proceso'],
                        ];
                    @endphp
                    @foreach($features as $i => $f)
                    <div class="opacity-0 animate-fade-in-up delay-{{ min($i * 100, 300) }} transform transition duration-300 hover:scale-105">
                        <x-ui.card glassmorphism="true" padding="lg" class="h-full text-center">
                            <div class="w-14 h-14 mx-auto mb-4 rounded-xl bg-white/20 flex items-center justify-center">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $f['icon'] }}" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-white mb-2">{{ $f['title'] }}</h3>
                            <p class="text-white/80 text-sm sm:text-base">{{ $f['desc'] }}</p>
                        </x-ui.card>
                    </div>
                    @endforeach
                </x-ui.grid>
            </x-ui.container>
        </section>

        {{-- ¿Para quién está enfocado? --}}
        <section class="py-16 sm:py-20">
            <x-ui.container>
                <div class="text-center mb-16 opacity-0 animate-fade-in-up delay-100">
                    <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-white mb-6">
                        ¿Para quién está enfocado?
                    </h2>
                    <p class="text-lg sm:text-xl text-white/85 max-w-3xl mx-auto">
                        La plataforma está diseñada para <strong class="text-white">personas en Ecuador</strong> que desean comprar en tiendas online de Estados Unidos — Amazon, eBay, tiendas especializadas— sin las complicaciones de la importación.
                    </p>
                </div>

                <x-ui.grid :cols="1" :cols-sm="2" gap="default">
                    <div class="opacity-0 animate-fade-in-left delay-200">
                        <x-ui.card glassmorphism="true" padding="lg" class="h-full border-l-4 border-white/40 hover:border-white/70 transition-colors">
                            <h3 class="text-xl font-semibold text-white mb-3">Particulares</h3>
                            <p class="text-white/80 text-sm sm:text-base">
                                Personas que compran para uso personal: electrónica, ropa, decoración del hogar, productos que no encuentran fácilmente en Ecuador o que buscan mejores precios.
                            </p>
                        </x-ui.card>
                    </div>
                    <div class="opacity-0 animate-fade-in-left delay-300">
                        <x-ui.card glassmorphism="true" padding="lg" class="h-full border-l-4 border-white/40 hover:border-white/70 transition-colors">
                            <h3 class="text-xl font-semibold text-white mb-3">Emprendedores y revendedores</h3>
                            <p class="text-white/80 text-sm sm:text-base">
                                Quienes importan productos para revender o para sus negocios, aprovechando la consolidación de paquetes y tarifas competitivas para optimizar costos.
                            </p>
                        </x-ui.card>
                    </div>
                </x-ui.grid>
            </x-ui.container>
        </section>

        {{-- Puntos fuertes --}}
        <section class="py-16 sm:py-20" style="background: rgba(255, 255, 255, 0.08); backdrop-filter: blur(12px);">
            <x-ui.container>
                <div class="text-center mb-16 opacity-0 animate-fade-in-up delay-100">
                    <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-white mb-6">
                        Puntos fuertes
                    </h2>
                    <p class="text-lg sm:text-xl text-white/85 max-w-3xl mx-auto">
                        Lo que diferencia a Flat Rate Imports y lo hace una opción atractiva para sus usuarios.
                    </p>
                </div>

                <x-ui.grid :cols="1" :cols-sm="2" :cols-md="2" gap="default">
                    @php
                        $strengths = [
                            ['title' => 'Experiencia en el mercado', 'desc' => 'Más de 10 años en el sector de importación, con conocimiento profundo de regulaciones y procesos logísticos.'],
                            ['title' => 'Proceso transparente', 'desc' => 'Cotización clara antes de comprar, seguimiento en tiempo real y comunicación directa con el cliente.'],
                            ['title' => 'Casillero gratuito', 'desc' => 'Dirección en USA sin costo de registro, accesible para todos los usuarios desde el primer día.'],
                            ['title' => 'Integración con tienda propia', 'desc' => 'Además del casillero, oferta productos curados en su tienda online para una experiencia completa.'],
                            ['title' => 'Herramientas de soporte', 'desc' => 'Calculadoras de aranceles, blog con contenido útil y atención al cliente vía WhatsApp y chat.'],
                            ['title' => 'Marketing y SEO integrado', 'desc' => 'Páginas SEO dinámicas, captura de leads, automación con webhooks y analítica para medir y optimizar.'],
                            ['title' => 'Plataforma adaptable', 'desc' => 'Sistema configurable para ajustar contenido, ofertas y mensajes según las necesidades del negocio.'],
                        ];
                    @endphp
                    @foreach($strengths as $i => $s)
                    <div class="opacity-0 animate-fade-in-up delay-{{ [0, 100, 200, 300, 400, 400][$i] ?? 400 }} group">
                        <x-ui.card glassmorphism="true" padding="lg" class="h-full transition-all duration-300 hover:bg-white/15">
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 rounded-lg bg-white/20 group-hover:bg-white/30 flex items-center justify-center flex-shrink-0 transition-colors">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-white mb-2">{{ $s['title'] }}</h3>
                                    <p class="text-white/80 text-sm sm:text-base">{{ $s['desc'] }}</p>
                                </div>
                            </div>
                        </x-ui.card>
                    </div>
                    @endforeach
                </x-ui.grid>
            </x-ui.container>
        </section>

        {{-- Marketing y SEO implementado --}}
        <section class="py-16 sm:py-20" style="background: rgba(255, 255, 255, 0.08); backdrop-filter: blur(12px);">
            <x-ui.container>
                <div class="text-center mb-16 opacity-0 animate-fade-in-up delay-100">
                    <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-white mb-6">
                        Marketing y SEO implementado
                    </h2>
                    <p class="text-lg sm:text-xl text-white/85 max-w-3xl mx-auto">
                        La plataforma incluye herramientas ya construidas para atraer visitantes, capturar leads y medir resultados. Todo esto está operativo y listo para usar.
                    </p>
                </div>

                <x-ui.grid :cols="1" :cols-sm="2" :cols-md="3" gap="default">
                    @php
                        $marketingItems = [
                            ['title' => 'Visibilidad en buscadores', 'desc' => 'Sitemap, meta tags y Open Graph configurados para que Google y redes sociales indexen correctamente cada página.'],
                            ['title' => 'Páginas SEO dinámicas', 'desc' => 'Creación de páginas por palabra clave (ej: "importar iPhone desde Amazon"). El panel admin permite crear y editar sin programar.'],
                            ['title' => 'Blog con contenido útil', 'desc' => 'Artículos sobre importación, aranceles y guías. Atrae tráfico orgánico y genera confianza.'],
                            ['title' => 'Calculadoras virales', 'desc' => 'Páginas dedicadas: aranceles Ecuador, Courier 4x4, Amazon a Ecuador. Cada una con cotizador integrado y enlaces a la tienda.'],
                            ['title' => 'Cotización compartible', 'desc' => 'El usuario puede compartir su cotización por enlace. Cada enlace es una página indexable que puede llevar tráfico nuevo.'],
                            ['title' => 'Captura automática de leads', 'desc' => 'Cada vez que alguien cotiza o envía cotización por email, se guarda como lead con puntuación según valor y producto.'],
                            ['title' => 'Panel de leads', 'desc' => 'Listado de leads con filtros por score, producto y país. Permite priorizar seguimiento comercial.'],
                            ['title' => 'Automatización con webhooks', 'desc' => 'Cada lead nuevo se envía a una URL configurable (n8n, Zapier, CRM). Permite automatizar emails, notificaciones y campañas.'],
                            ['title' => 'Medición y analítica', 'desc' => 'Integración con Google Analytics y PostHog. Eventos de cotización, envío por email y clics a tienda.'],
                            ['title' => 'Widget embebible', 'desc' => 'El cotizador puede embeberse en otras webs mediante iframe. Amplía el alcance sin coste adicional.'],
                        ];
                    @endphp
                    @foreach($marketingItems as $i => $m)
                    <div class="opacity-0 animate-fade-in-up delay-{{ [0, 75, 150, 225, 300, 375, 400, 400, 400, 400][$i] ?? 400 }} group">
                        <x-ui.card glassmorphism="true" padding="lg" class="h-full transition-all duration-300 hover:bg-white/15">
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 rounded-lg bg-green-500/30 group-hover:bg-green-500/40 flex items-center justify-center flex-shrink-0 transition-colors">
                                    <svg class="w-5 h-5 text-green-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-white mb-2">{{ $m['title'] }}</h3>
                                    <p class="text-white/80 text-sm sm:text-base">{{ $m['desc'] }}</p>
                                </div>
                            </div>
                        </x-ui.card>
                    </div>
                    @endforeach
                </x-ui.grid>
            </x-ui.container>
        </section>

        {{-- Tiempos para generar clientes en masa --}}
        <section class="py-16 sm:py-20">
            <x-ui.container>
                <div class="text-center mb-16 opacity-0 animate-fade-in-up delay-100">
                    <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-white mb-6">
                        Tiempos para generar clientes en masa
                    </h2>
                    <p class="text-lg sm:text-xl text-white/85 max-w-3xl mx-auto">
                        Expectativas realistas sobre cuándo se verán resultados en volumen, según la estrategia que se siga.
                    </p>
                </div>

                <x-ui.grid :cols="1" :cols-sm="2" :cols-md="3" gap="default">
                    @php
                        $timelines = [
                            ['phase' => 'Fase inicial', 'months' => '1–3 meses', 'desc' => 'Los leads empiezan a capturarse desde el primer día si hay tráfico. Las primeras cotizaciones y registros aparecen con el tráfico existente (redes, referidos, anuncios).'],
                            ['phase' => 'SEO orgánico', 'months' => '1–3 meses', 'desc' => 'Las primeras páginas SEO y calculadoras pueden empezar a aparecer en Google. El tráfico orgánico crece de forma gradual.'],
                            ['phase' => 'SEO consolidado', 'months' => '4–6 meses', 'desc' => 'Con contenido constante (blog, páginas SEO nuevas), el SEO empieza a dar resultados más visibles. Más visitas y más leads sin depender solo de anuncios.'],
                            ['phase' => 'Clientes en masa', 'months' => '6–12 meses', 'desc' => 'Para alcanzar volumen alto de clientes se recomienda combinar: SEO + email marketing + campañas de pago. El SEO aporta base sostenible; los ads aceleran el crecimiento.'],
                            ['phase' => 'Automatización', 'months' => 'Desde el inicio', 'desc' => 'Los webhooks y el panel de leads permiten automatizar seguimiento desde el día 1. Cada lead nuevo puede disparar emails, notificaciones o campañas sin intervención manual.'],
                            ['phase' => 'Factor clave', 'months' => 'Contenido', 'desc' => 'Más páginas SEO útiles y artículos de blog = más palabras clave = más tráfico. La plataforma está diseñada para escalar: crear contenido es la palanca principal.'],
                        ];
                    @endphp
                    @foreach($timelines as $i => $t)
                    <div class="opacity-0 animate-fade-in-up delay-{{ [0, 100, 200, 300, 400, 400][$i] ?? 400 }}">
                        <x-ui.card glassmorphism="true" padding="lg" class="h-full border-t-4 border-white/30">
                            <h3 class="text-lg font-semibold text-white mb-2">{{ $t['phase'] }}</h3>
                            <p class="text-green-200/90 font-semibold text-sm mb-3">{{ $t['months'] }}</p>
                            <p class="text-white/80 text-sm sm:text-base">{{ $t['desc'] }}</p>
                        </x-ui.card>
                    </div>
                    @endforeach
                </x-ui.grid>

                <div class="mt-12 opacity-0 animate-fade-in-up delay-500">
                    <x-ui.card glassmorphism="true" padding="lg" class="max-w-3xl mx-auto text-center">
                        <p class="text-white/90 text-lg mb-4">
                            <strong class="text-white">Resumen:</strong> La plataforma está diseñada para capturar y nutrir leads desde el primer día. 
                            Para alcanzar <strong class="text-white">clientes en masa</strong> se requiere tiempo combinando SEO (4–6 meses para ver resultados sólidos), 
                            contenido constante y, opcionalmente, inversión en campañas de pago para acelerar el crecimiento.
                        </p>
                    </x-ui.card>
                </div>
            </x-ui.container>
        </section>

        {{-- ¿Qué se espera del proyecto? --}}
        <section class="py-16 sm:py-20" style="background: rgba(255, 255, 255, 0.08); backdrop-filter: blur(12px);">
            <x-ui.container>
                <div class="text-center mb-16 opacity-0 animate-fade-in-up delay-100">
                    <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-white mb-6">
                        ¿Qué se espera del proyecto?
                    </h2>
                    <p class="text-lg sm:text-xl text-white/85 max-w-3xl mx-auto">
                        Objetivos y expectativas a largo plazo para el crecimiento y la sostenibilidad del negocio.
                    </p>
                </div>

                <div class="max-w-3xl mx-auto space-y-6">
                    @php
                        $expectations = [
                            'Aumentar la base de clientes y el número de cotizaciones realizadas a través de la plataforma.',
                            'Fortalecer la presencia digital con contenido útil (blog, calculadoras) que atraiga tráfico orgánico y genere confianza.',
                            'Mejorar la conversión de visitantes a usuarios registrados y de cotizaciones a envíos concretos.',
                            'Mantener una experiencia de usuario fluida, accesible desde móvil y fácil de usar para personas sin experiencia en importación.',
                            'Posicionar a Flat Rate Imports como referencia en el sector de importación USA–Ecuador.',
                        ];
                    @endphp
                    @foreach($expectations as $i => $e)
                    <div class="opacity-0 animate-fade-in-left delay-{{ [0, 100, 200, 300, 400][$i] ?? 400 }}">
                        <x-ui.card glassmorphism="true" padding="md" class="flex items-center gap-4">
                            <span class="text-2xl font-bold text-white/60 flex-shrink-0">{{ $i + 1 }}</span>
                            <p class="text-white/90 text-base sm:text-lg">{{ $e }}</p>
                        </x-ui.card>
                    </div>
                    @endforeach
                </div>
            </x-ui.container>
        </section>

        {{-- CTA Final --}}
        <section class="py-16 sm:py-24">
            <x-ui.container>
                <div class="text-center opacity-0 animate-fade-in-up delay-200">
                    <x-ui.card glassmorphism="true" padding="lg" class="max-w-2xl mx-auto">
                        <h3 class="text-2xl sm:text-3xl font-bold text-white mb-4">
                            ¿Listo para explorar la plataforma?
                        </h3>
                        <p class="text-white/85 mb-8">
                            Visita el sitio web y descubre todo lo que Flat Rate Imports puede ofrecer.
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            <a href="{{ route('home') }}" class="glass-button glass-button-lg">
                                Ir al inicio
                            </a>
                            <a href="{{ route('cotizador') }}" class="glass-button glass-button-lg" style="background: rgba(255, 255, 255, 0.15);">
                                Probar cotizador
                            </a>
                        </div>
                    </x-ui.card>
                </div>
            </x-ui.container>
        </section>
    </div>
</x-guest-layout>
