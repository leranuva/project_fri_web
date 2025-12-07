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
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
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
                    <a href="https://flatrateimports.com/" target="_blank" class="nav-link">
                        <svg class="nav-icon" viewBox="0 0 24 24">
                            <path d="M16 11V7a4 4 0 0 0-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        <span>Tienda</span>
                    </a>
                </li>
                @auth
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <svg class="nav-icon" viewBox="0 0 24 24">
                                <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                                <path d="M16 3h6v4"></path>
                                <path d="m22 7-10-4-10 4"></path>
                            </svg>
                            <span>Dashboard</span>
                        </a>
                    </li>
                @endauth
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
                @else
                    <li class="nav-item">
                        <a href="{{ route('profile.edit') }}" class="nav-link">
                            <svg class="nav-icon" viewBox="0 0 24 24">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                            <span>Perfil</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="cta-button logout-button" style="display: inline-flex; align-items: center; gap: 6px;">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 16px; height: 16px;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                                <span>Cerrar Sesión</span>
                            </button>
                        </form>
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
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
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
                    href="https://flatrateimports.com/" 
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
            @auth
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
                        <span>Dashboard</span>
                    </a>
                </li>
            @endauth
        </ul>
        
        <div class="mobile-cta">
            @guest
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
            @else
                <a 
                    href="{{ route('profile.edit') }}" 
                    class="mobile-cta-button"
                    @click="mobileMenuOpen = false"
                >
                    Ver Perfil
                </a>
                <form method="POST" action="{{ route('logout') }}" class="w-full mt-2">
                    @csrf
                    <button 
                        type="submit" 
                        class="mobile-cta-button logout-button"
                        @click="mobileMenuOpen = false"
                    >
                        <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        Cerrar Sesión
                    </button>
                </form>
            @endguest
        </div>
    </div>
</div>
