{{-- Floating Background Elements --}}
<div class="floating-elements">
    <div class="floating-circle"></div>
    <div class="floating-circle"></div>
    <div class="floating-circle"></div>
</div>

{{-- Advanced Navigation Bar --}}
<div x-data="{ mobileMenuOpen: false }" @keydown.escape.window="mobileMenuOpen = false">
    <nav class="navbar-container">
        <div class="navbar">
            {{-- Brand/Logo --}}
            <a href="{{ route('home') }}" class="navbar-brand">
                <div class="logo-icon">
                    @if(isset($activeLogo) && $activeLogo && $activeLogo->image_path)
                        <img src="{{ asset($activeLogo->image_path) }}" alt="Flat Rate Imports">
                    @else
                        <img src="{{ asset('logo_fri.png') }}" alt="Flat Rate Imports">
                    @endif
                </div>
                <span class="brand-text">Flat Rate Imports</span>
            </a>

            {{-- Navigation Links --}}
            <ul class="navbar-nav" id="navbarNav">
                <li class="nav-item">
                    <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                        <svg class="nav-icon" viewBox="0 0 24 24">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                            <polyline points="9,22 9,12 15,12 15,22"></polyline>
                        </svg>
                        <span>Inicio</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('cotizador') }}" class="nav-link {{ request()->routeIs('cotizador') ? 'active' : '' }}">
                        <svg class="nav-icon" viewBox="0 0 24 24">
                            <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
                            <line x1="8" y1="21" x2="16" y2="21"></line>
                            <line x1="12" y1="17" x2="12" y2="21"></line>
                        </svg>
                        <span>Cotizador</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('blog.index') }}" class="nav-link {{ request()->routeIs('blog.*') ? 'active' : '' }}">
                        <svg class="nav-icon" viewBox="0 0 24 24">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14,2 14,8 20,8"></polyline>
                            <line x1="16" y1="13" x2="8" y2="13"></line>
                            <line x1="16" y1="17" x2="8" y2="17"></line>
                        </svg>
                        <span>Blog</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="https://flatrateimports.store/" target="_blank" class="nav-link">
                        <svg class="nav-icon" viewBox="0 0 24 24">
                            <path d="M16 11V7a4 4 0 0 0-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        <span>Tienda</span>
                    </a>
                </li>
                @guest
                    <li class="nav-item">
                        <a href="{{ route('login') }}" class="nav-link">
                            <svg class="nav-icon" viewBox="0 0 24 24">
                                <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path>
                                <polyline points="10,17 15,12 10,7"></polyline>
                                <line x1="15" y1="12" x2="3" y2="12"></line>
                            </svg>
                            <span>Iniciar Sesión</span>
                        </a>
                    </li>
                @endguest
                @guest
                    <li class="nav-item">
                        <a href="{{ route('register') }}" class="cta-button">
                            Registrarse
                        </a>
                    </li>
                @endguest
            </ul>

            {{-- Mobile Toggle --}}
            <button 
                type="button"
                class="mobile-toggle" 
                @click="mobileMenuOpen = !mobileMenuOpen"
                :class="{ 'active': mobileMenuOpen }"
                aria-label="Toggle menu"
                :aria-expanded="mobileMenuOpen"
            >
                <div class="hamburger">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </button>
        </div>
    </nav>

    {{-- Mobile Menu Overlay --}}
    <div 
        class="mobile-menu-overlay" 
        x-show="mobileMenuOpen"
        x-cloak
        @click="mobileMenuOpen = false"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
    ></div>

    {{-- Mobile Menu --}}
    <div 
        class="mobile-menu" 
        x-show="mobileMenuOpen"
        x-cloak
        x-transition:enter="transition ease-out duration-300 transform"
        x-transition:enter-start="-translate-y-full"
        x-transition:enter-end="translate-y-0"
        x-transition:leave="transition ease-in duration-200 transform"
        x-transition:leave-start="translate-y-0"
        x-transition:leave-end="-translate-y-full"
    >
        <div class="mobile-menu-header">
            <a href="{{ route('home') }}" class="mobile-menu-brand" @click="mobileMenuOpen = false">
                <div class="logo-icon">
                    @if(isset($activeLogo) && $activeLogo && $activeLogo->image_path)
                        <img src="{{ asset($activeLogo->image_path) }}" alt="Flat Rate Imports">
                    @else
                        <img src="{{ asset('logo_fri.png') }}" alt="Flat Rate Imports">
                    @endif
                </div>
                <span class="brand-text">Flat Rate Imports</span>
            </a>
            <button 
                type="button"
                class="mobile-menu-close" 
                @click="mobileMenuOpen = false"
                aria-label="Close menu"
            >
                <span>×</span>
            </button>
        </div>
        
        <ul class="mobile-menu-nav">
            @auth
                {{-- Información del Usuario --}}
                <li class="mobile-menu-item mobile-user-info">
                    @php
                        $name = Auth::user()->name;
                        $initials = '';
                        $words = explode(' ', trim($name));
                        if (count($words) >= 2) {
                            $initials = strtoupper(substr($words[0], 0, 1) . substr($words[count($words) - 1], 0, 1));
                        } else {
                            $initials = strtoupper(substr($name, 0, 2));
                        }
                    @endphp
                    <div class="flex items-center gap-3 px-4 py-3">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center flex-shrink-0">
                            <span class="text-white font-semibold text-base">{{ $initials }}</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-white font-semibold text-sm truncate">{{ Auth::user()->name }}</p>
                            <p class="text-white/70 text-xs truncate">{{ Auth::user()->email }}</p>
                            <span class="inline-block mt-1 px-2 py-0.5 bg-white/20 rounded-full text-white text-xs font-medium">
                                {{ Auth::user()->role === 'admin' ? 'Administrador' : 'Cliente' }}
                            </span>
                        </div>
                    </div>
                </li>
                
                <li class="mobile-menu-divider"></li>
                
                {{-- Panel de Control --}}
                <li class="mobile-menu-item">
                    <a 
                        href="{{ route('dashboard') }}" 
                        class="mobile-menu-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                        @click="mobileMenuOpen = false"
                    >
                        <svg class="mobile-menu-icon" viewBox="0 0 24 24">
                            <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                            <path d="M16 3h6v4"></path>
                            <path d="m22 7-10-4-10 4"></path>
                        </svg>
                        <span>Panel de Control</span>
                    </a>
                </li>
                
                @if(Auth::user()->role === 'admin')
                    <li class="mobile-menu-divider"></li>
                    <li class="mobile-menu-item">
                        <p class="mobile-menu-section">Administración</p>
                    </li>
                    <li class="mobile-menu-item">
                        <a 
                            href="{{ route('admin.users.index') }}" 
                            class="mobile-menu-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}"
                            @click="mobileMenuOpen = false"
                        >
                            <svg class="mobile-menu-icon" viewBox="0 0 24 24">
                                <path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                            <span>Usuarios</span>
                        </a>
                    </li>
                    <li class="mobile-menu-item">
                        <a 
                            href="{{ route('admin.logos.index') }}" 
                            class="mobile-menu-link {{ request()->routeIs('admin.logos.*') ? 'active' : '' }}"
                            @click="mobileMenuOpen = false"
                        >
                            <svg class="mobile-menu-icon" viewBox="0 0 24 24">
                                <path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span>Logotipos</span>
                        </a>
                    </li>
                    <li class="mobile-menu-item">
                        <a 
                            href="{{ route('admin.products.index') }}" 
                            class="mobile-menu-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}"
                            @click="mobileMenuOpen = false"
                        >
                            <svg class="mobile-menu-icon" viewBox="0 0 24 24">
                                <path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                            <span>Productos</span>
                        </a>
                    </li>
                @endif
                
                <li class="mobile-menu-divider"></li>
            @endauth
            
            <li class="mobile-menu-item">
                <a 
                    href="{{ route('home') }}" 
                    class="mobile-menu-link {{ request()->routeIs('home') ? 'active' : '' }}"
                    @click="mobileMenuOpen = false"
                >
                    <svg class="mobile-menu-icon" viewBox="0 0 24 24">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                        <polyline points="9,22 9,12 15,12 15,22"></polyline>
                    </svg>
                    <span>Inicio</span>
                </a>
            </li>
            <li class="mobile-menu-item">
                <a 
                    href="{{ route('cotizador') }}" 
                    class="mobile-menu-link {{ request()->routeIs('cotizador') ? 'active' : '' }}"
                    @click="mobileMenuOpen = false"
                >
                    <svg class="mobile-menu-icon" viewBox="0 0 24 24">
                        <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
                        <line x1="8" y1="21" x2="16" y2="21"></line>
                        <line x1="12" y1="17" x2="12" y2="21"></line>
                    </svg>
                    <span>Cotizador</span>
                </a>
            </li>
            <li class="mobile-menu-item">
                <a 
                    href="{{ route('blog.index') }}" 
                    class="mobile-menu-link {{ request()->routeIs('blog.*') ? 'active' : '' }}"
                    @click="mobileMenuOpen = false"
                >
                    <svg class="mobile-menu-icon" viewBox="0 0 24 24">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14,2 14,8 20,8"></polyline>
                        <line x1="16" y1="13" x2="8" y2="13"></line>
                        <line x1="16" y1="17" x2="8" y2="17"></line>
                    </svg>
                    <span>Blog</span>
                </a>
            </li>
            <li class="mobile-menu-item">
                <a 
                    href="https://flatrateimports.store/" 
                    target="_blank"
                    class="mobile-menu-link"
                    @click="mobileMenuOpen = false"
                >
                    <svg class="mobile-menu-icon" viewBox="0 0 24 24">
                        <path d="M16 11V7a4 4 0 0 0-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    <span>Tienda</span>
                </a>
            </li>
        </ul>
        
        <div class="mobile-cta">
            @auth
                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <button 
                        type="submit" 
                        class="mobile-cta-button mobile-logout-button"
                        @click="mobileMenuOpen = false"
                    >
                        <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        Cerrar Sesión
                    </button>
                </form>
            @else
                <a 
                    href="{{ route('login') }}" 
                    class="mobile-cta-button"
                    @click="mobileMenuOpen = false"
                    style="background: linear-gradient(135deg, rgba(255, 255, 255, 0.2), rgba(255, 255, 255, 0.1)); margin-bottom: 0.75rem;"
                >
                    <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path>
                        <polyline points="10,17 15,12 10,7"></polyline>
                        <line x1="15" y1="12" x2="3" y2="12"></line>
                    </svg>
                    Iniciar Sesión
                </a>
                <a 
                    href="{{ route('register') }}" 
                    class="mobile-cta-button"
                    @click="mobileMenuOpen = false"
                >
                    Registrarse
                </a>
            @endauth
        </div>
    </div>
</div>
