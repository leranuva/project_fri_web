<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-white leading-tight">
            @if(Auth::user()->role === 'admin')
            {{ __('Dashboard') }}
            @else
                {{ __('Mi Perfil') }}
            @endif
        </h2>
    </x-slot>

    <x-ui.container>
        {{-- Mensaje de Bienvenida --}}
        <div class="mb-6 sm:mb-8">
            <x-ui.card glassmorphism="true" padding="lg" class="welcome-card">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div>
                        <h1 class="text-2xl sm:text-3xl font-bold text-white mb-2">
                            @if(Auth::user()->role === 'admin')
                            ¡Bienvenido, {{ Auth::user()->name }}!
                            @else
                                Mi Perfil
                            @endif
                        </h1>
                        <p class="text-sm sm:text-base text-white/80">
                            @if(Auth::user()->role === 'admin')
                            {{ __('Estás conectado al panel de control de Flat Rate Imports.') }}
                            @else
                                {{ __('Gestiona tu información personal y accede a los servicios de Flat Rate Imports.') }}
                            @endif
                        </p>
                    </div>
                    <div class="flex items-center gap-3">
                        @php
                            // Obtener iniciales del nombre
                            $name = Auth::user()->name;
                            $initials = '';
                            $words = explode(' ', trim($name));
                            if (count($words) >= 2) {
                                // Si tiene al menos 2 palabras, tomar primera letra de cada una
                                $initials = strtoupper(substr($words[0], 0, 1) . substr($words[count($words) - 1], 0, 1));
                            } else {
                                // Si solo tiene una palabra, tomar las primeras 2 letras
                                $initials = strtoupper(substr($name, 0, 2));
                            }
                        @endphp
                        <div class="w-16 h-16 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center border-2 border-white/20 shadow-lg">
                            <span class="text-xl font-bold text-white">{{ $initials }}</span>
                        </div>
                        <div>
                            <p class="text-sm text-white/70">Nombre de Cliente</p>
                            <p class="text-base font-semibold text-white">{{ Auth::user()->name }}</p>
                        </div>
                    </div>
                </div>
            </x-ui.card>
        </div>

        {{-- Analytics de cotizaciones (solo para administradores) --}}
        @if(Auth::user()->role === 'admin' && isset($analytics))
        <x-ui.card glassmorphism="true" padding="lg" class="mb-6">
            <h3 class="text-xl font-semibold text-white mb-4">Analytics de Cotizaciones</h3>
            <x-ui.grid :cols="1" :cols-sm="2" :cols-md="4" gap="default" class="mb-6">
                <div class="bg-white/10 rounded-lg p-4">
                    <p class="text-white/60 text-sm">Hoy</p>
                    <p class="text-2xl font-bold text-white">{{ $analytics['quotes_today'] ?? 0 }}</p>
                </div>
                <div class="bg-white/10 rounded-lg p-4">
                    <p class="text-white/60 text-sm">Esta semana</p>
                    <p class="text-2xl font-bold text-white">{{ $analytics['quotes_this_week'] ?? 0 }}</p>
                </div>
                <div class="bg-white/10 rounded-lg p-4">
                    <p class="text-white/60 text-sm">Total</p>
                    <p class="text-2xl font-bold text-white">{{ $analytics['quotes_total'] ?? 0 }}</p>
                </div>
                <div class="bg-white/10 rounded-lg p-4">
                    <p class="text-white/60 text-sm">Valor promedio</p>
                    <p class="text-2xl font-bold text-white">${{ number_format($analytics['avg_total'] ?? 0, 2) }}</p>
                </div>
            </x-ui.grid>
            @if(($analytics['top_products'] ?? collect())->isNotEmpty())
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <h4 class="text-white/80 font-medium mb-2">Productos más cotizados</h4>
                    <ul class="space-y-1 text-sm text-white/70">
                        @foreach($analytics['top_products'] as $item)
                            <li>{{ $item->product_key }} ({{ $item->total }})</li>
                        @endforeach
                    </ul>
                </div>
                <div>
                    <h4 class="text-white/80 font-medium mb-2">Métodos de envío más usados</h4>
                    <ul class="space-y-1 text-sm text-white/70">
                        @foreach($analytics['top_shipping_methods'] as $item)
                            <li>{{ ucfirst($item->shipping_method) }} ({{ $item->total }})</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif
        </x-ui.card>
        @endif

        {{-- Grid de estadísticas (solo para administradores) --}}
        @if(Auth::user()->role === 'admin' && $stats)
        <x-ui.grid :cols="1" :cols-sm="2" :cols-md="4" gap="default" class="mb-6 sm:mb-8">
            <x-app.dashboard-stats 
                title="Usuarios Totales" 
                :value="number_format($stats['total_users'] ?? 0)" 
                icon="fas fa-users"
                color="blue"
            />
            <x-app.dashboard-stats 
                title="Administradores" 
                :value="number_format($stats['admin_users'] ?? 0)" 
                icon="fas fa-user-shield"
                color="purple"
            />
            <x-app.dashboard-stats 
                title="Clientes" 
                :value="number_format($stats['customer_users'] ?? 0)" 
                icon="fas fa-user"
                color="green"
            />
            <x-app.dashboard-stats 
                title="Productos" 
                :value="number_format($stats['total_products'] ?? 0)" 
                icon="fas fa-box"
                color="yellow"
            />
        </x-ui.grid>
        @endif

        {{-- Contenido principal con grid 1/2 columnas --}}
        <x-ui.grid :cols="1" :cols-sm="1" :cols-md="2" gap="default" class="mb-6 sm:mb-8">
            {{-- Card de Bienvenida --}}
            <x-ui.card glassmorphism="true" padding="lg" class="dashboard-content-card">
                <div class="flex items-start gap-4 mb-4">
                    <div class="p-3 rounded-xl bg-gradient-to-br from-green-500/30 to-green-600/20 backdrop-blur-sm border border-white/20">
                        <svg class="w-6 h-6 text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-lg sm:text-xl font-semibold mb-2 text-white">
                            @if(Auth::user()->role === 'admin')
                            Estado de la Cuenta
                            @else
                                Información Personal
                            @endif
                        </h3>
                        <p class="text-sm sm:text-base text-white/80 mb-4">
                            @if(Auth::user()->role === 'admin')
                            Tu cuenta está activa y funcionando correctamente.
                            @else
                                Gestiona tu información personal y preferencias de cuenta.
                            @endif
                        </p>
                        <div class="space-y-2">
                            <div class="flex items-center gap-2 text-sm text-white/70">
                                <svg class="w-4 h-4 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                <span><strong>Nombre:</strong> {{ Auth::user()->name }}</span>
                            </div>
                            <div class="flex items-center gap-2 text-sm text-white/70">
                                <svg class="w-4 h-4 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                <span><strong>Email:</strong> {{ Auth::user()->email }}</span>
                            </div>
                            <div class="flex items-center gap-2 text-sm text-white/70">
                                <svg class="w-4 h-4 {{ Auth::user()->email_verified_at ? 'text-green-300' : 'text-yellow-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                <span>Email verificado: {{ Auth::user()->email_verified_at ? 'Sí' : 'No' }}</span>
                            </div>
                            <div class="flex items-center gap-2 text-sm text-white/70">
                                <svg class="w-4 h-4 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span>Cuenta creada: {{ Auth::user()->created_at->format('d/m/Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-white/10">
                    <a href="{{ route('profile.edit') }}" class="glass-button glass-button-sm">
                        @if(Auth::user()->role === 'admin')
                        Ver Perfil
                        @else
                            Editar Perfil
                        @endif
                    </a>
                </div>
            </x-ui.card>

            {{-- Card de Acciones Rápidas --}}
            <x-ui.card glassmorphism="true" padding="lg" class="dashboard-content-card">
                <div class="flex items-start gap-4 mb-4">
                    <div class="p-3 rounded-xl bg-gradient-to-br from-blue-500/30 to-blue-600/20 backdrop-blur-sm border border-white/20">
                        <svg class="w-6 h-6 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-lg sm:text-xl font-semibold mb-2 text-white">
                            Acciones Rápidas
                        </h3>
                        <p class="text-sm sm:text-base text-white/80 mb-4">
                            Accede rápidamente a las funciones principales.
                        </p>
                        <div class="space-y-2">
                            <a href="{{ route('cotizador') }}" class="block p-3 rounded-lg bg-white/10 hover:bg-white/20 border border-white/20 transition-all duration-200 text-white text-sm font-medium">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                    </svg>
                                    <span>Crear Cotización</span>
                                </div>
                            </a>
                            <a href="{{ route('quotes.index') }}" class="block p-3 rounded-lg bg-white/10 hover:bg-white/20 border border-white/20 transition-all duration-200 text-white text-sm font-medium">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>Mis Cotizaciones</span>
                                </div>
                            </a>
                            <a href="{{ route('packages.index') }}" class="block p-3 rounded-lg bg-white/10 hover:bg-white/20 border border-white/20 transition-all duration-200 text-white text-sm font-medium">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                    </svg>
                                    <span>Mis Paquetes</span>
                                </div>
                            </a>
                            <a href="{{ route('home') }}" class="block p-3 rounded-lg bg-white/10 hover:bg-white/20 border border-white/20 transition-all duration-200 text-white text-sm font-medium">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                    </svg>
                                    <span>Ir al Inicio</span>
                                </div>
                            </a>
                            
                            @if(Auth::user()->role === 'admin')
                                <div class="pt-3 mt-3 border-t border-white/10">
                                    <p class="text-xs font-semibold text-white/60 uppercase mb-2">Administración</p>
                                    <a href="{{ route('admin.users.index') }}" class="block p-3 rounded-lg bg-white/10 hover:bg-white/20 border border-white/20 transition-all duration-200 text-white text-sm font-medium mb-2">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                            </svg>
                                            <span>Usuarios</span>
                                        </div>
                                    </a>
                                    <a href="{{ route('admin.logos.index') }}" class="block p-3 rounded-lg bg-white/10 hover:bg-white/20 border border-white/20 transition-all duration-200 text-white text-sm font-medium mb-2">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <span>Logotipos</span>
                                        </div>
                                    </a>
                                    <a href="{{ route('admin.products.index') }}" class="block p-3 rounded-lg bg-white/10 hover:bg-white/20 border border-white/20 transition-all duration-200 text-white text-sm font-medium mb-2">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                            </svg>
                                            <span>Productos</span>
                                        </div>
                                    </a>
                                    <a href="{{ route('admin.shipping-rates.index') }}" class="block p-3 rounded-lg bg-white/10 hover:bg-white/20 border border-white/20 transition-all duration-200 text-white text-sm font-medium mb-2">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                                            </svg>
                                            <span>Tarifas de Envío</span>
                                        </div>
                                    </a>
                                    <a href="{{ route('admin.tax-rates.index') }}" class="block p-3 rounded-lg bg-white/10 hover:bg-white/20 border border-white/20 transition-all duration-200 text-white text-sm font-medium mb-2">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                            </svg>
                                            <span>Impuestos</span>
                                        </div>
                                    </a>
                                    <a href="{{ route('admin.sliders.index') }}" class="block p-3 rounded-lg bg-white/10 hover:bg-white/20 border border-white/20 transition-all duration-200 text-white text-sm font-medium mb-2">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <span>Slider Principal</span>
                                        </div>
                                    </a>
                                    <a href="{{ route('admin.process-steps.index') }}" class="block p-3 rounded-lg bg-white/10 hover:bg-white/20 border border-white/20 transition-all duration-200 text-white text-sm font-medium mb-2">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                            </svg>
                                            <span>Pasos del Proceso</span>
                                        </div>
                                    </a>
                                    <a href="{{ route('admin.process-sections.index') }}" class="block p-3 rounded-lg bg-white/10 hover:bg-white/20 border border-white/20 transition-all duration-200 text-white text-sm font-medium mb-2">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            <span>Configurar Sección "¿Cómo Funciona?"</span>
                                        </div>
                                    </a>
                                    <a href="{{ route('admin.alert-banners.index') }}" class="block p-3 rounded-lg bg-white/10 hover:bg-white/20 border border-white/20 transition-all duration-200 text-white text-sm font-medium mb-2">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                            </svg>
                                            <span>Banner de Alerta</span>
                                        </div>
                                    </a>
                                    <a href="{{ route('admin.benefits.index') }}" class="block p-3 rounded-lg bg-white/10 hover:bg-white/20 border border-white/20 transition-all duration-200 text-white text-sm font-medium mb-2">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span>Beneficios</span>
                                        </div>
                                    </a>
                                    <a href="{{ route('admin.stores.index') }}" class="block p-3 rounded-lg bg-white/10 hover:bg-white/20 border border-white/20 transition-all duration-200 text-white text-sm font-medium mb-2">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                            </svg>
                                            <span>Tiendas</span>
                                        </div>
                                    </a>
                                    <a href="{{ route('admin.blog-posts.index') }}" class="block p-3 rounded-lg bg-white/10 hover:bg-white/20 border border-white/20 transition-all duration-200 text-white text-sm font-medium mb-2">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                            </svg>
                                            <span>Blog / Artículos</span>
                                        </div>
                                    </a>
                                    <a href="{{ route('admin.blog-posts.create') }}" class="block p-3 rounded-lg bg-blue-500/20 hover:bg-blue-500/30 border border-blue-500/30 text-blue-200 hover:text-blue-100 transition-all duration-200 text-sm font-medium mb-2">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                            </svg>
                                            <span>Crear nuevo artículo</span>
                                        </div>
                                    </a>
                                    <a href="{{ route('admin.footer-links.index') }}" class="block p-3 rounded-lg bg-white/10 hover:bg-white/20 border border-white/20 transition-all duration-200 text-white text-sm font-medium mb-2">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            <span>Footer</span>
                                        </div>
                                    </a>
                                    <a href="{{ route('admin.cotizador-sections.index') }}" class="block p-3 rounded-lg bg-white/10 hover:bg-white/20 border border-white/20 transition-all duration-200 text-white text-sm font-medium mb-2">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                            </svg>
                                            <span>Cotizador</span>
                                        </div>
                                    </a>
                                    <a href="{{ route('admin.themes.index') }}" class="block p-3 rounded-lg bg-white/10 hover:bg-white/20 border border-white/20 transition-all duration-200 text-white text-sm font-medium mb-2">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                                            </svg>
                                            <span>Gestión de Temas</span>
                                        </div>
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </x-ui.card>
        </x-ui.grid>

        {{-- Sección adicional para clientes --}}
        @if(Auth::user()->role !== 'admin')
            <x-ui.grid :cols="1" :cols-sm="1" :cols-md="2" gap="default" class="mb-6 sm:mb-8">
                {{-- Información de Casillero --}}
                <x-ui.card glassmorphism="true" padding="lg" class="dashboard-content-card">
                    <div class="flex items-start gap-4 mb-4">
                        <div class="p-3 rounded-xl bg-gradient-to-br from-purple-500/30 to-purple-600/20 backdrop-blur-sm border border-white/20">
                            <svg class="w-6 h-6 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg sm:text-xl font-semibold mb-2 text-white">
                                Tu Dirección de Casillero
                            </h3>
                            <p class="text-sm sm:text-base text-white/80 mb-4">
                                Una vez que completes tu registro, recibirás tu dirección de casillero postal en USA para realizar tus compras internacionales.
                            </p>
                            <div class="space-y-2">
                                <div class="flex items-start gap-2 text-sm text-white/70">
                                    <svg class="w-4 h-4 text-purple-300 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>Usa tu dirección de casillero para comprar en tiendas online de USA</span>
                                </div>
                                <div class="flex items-start gap-2 text-sm text-white/70">
                                    <svg class="w-4 h-4 text-purple-300 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>Recibimos tus paquetes y los consolidamos para ahorrar en envío</span>
                                </div>
                                <div class="flex items-start gap-2 text-sm text-white/70">
                                    <svg class="w-4 h-4 text-purple-300 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>Te notificamos cuando tus paquetes lleguen y estén listos para enviar</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </x-ui.card>

                {{-- Ayuda y Soporte --}}
                <x-ui.card glassmorphism="true" padding="lg" class="dashboard-content-card">
                    <div class="flex items-start gap-4 mb-4">
                        <div class="p-3 rounded-xl bg-gradient-to-br from-yellow-500/30 to-yellow-600/20 backdrop-blur-sm border border-white/20">
                            <svg class="w-6 h-6 text-yellow-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg sm:text-xl font-semibold mb-2 text-white">
                                ¿Necesitas Ayuda?
                            </h3>
                            <p class="text-sm sm:text-base text-white/80 mb-4">
                                Estamos aquí para ayudarte con cualquier pregunta sobre nuestros servicios.
                            </p>
                            <div class="space-y-2">
                                <a href="{{ route('cotizador') }}" class="block p-3 rounded-lg bg-white/10 hover:bg-white/20 border border-white/20 transition-all duration-200 text-white text-sm font-medium">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                        </svg>
                                        <span>Calcular Costos de Envío</span>
                                    </div>
                                </a>
                                <a href="{{ route('home') }}" class="block p-3 rounded-lg bg-white/10 hover:bg-white/20 border border-white/20 transition-all duration-200 text-white text-sm font-medium">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span>Ver Información del Servicio</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </x-ui.card>
            </x-ui.grid>
        @endif
    </x-ui.container>
</x-app-layout>
