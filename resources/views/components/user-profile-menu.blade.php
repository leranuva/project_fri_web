{{-- User Profile Menu - Esquina Superior Derecha --}}
@auth
    @php
        // Obtener iniciales del nombre
        $name = Auth::user()->name;
        $initials = '';
        $words = explode(' ', trim($name));
        if (count($words) >= 2) {
            $initials = strtoupper(substr($words[0], 0, 1) . substr($words[count($words) - 1], 0, 1));
        } else {
            $initials = strtoupper(substr($name, 0, 2));
        }
    @endphp
    
    <div 
        x-data="{ profileMenuOpen: false }" 
        @click.away="profileMenuOpen = false"
        class="user-profile-menu"
    >
        {{-- Botón de Perfil --}}
        <button 
            type="button"
            @click="profileMenuOpen = !profileMenuOpen"
            class="user-profile-button"
            :class="{ 'active': profileMenuOpen }"
        >
            <div class="user-profile-avatar">
                <span class="user-profile-initials">{{ $initials }}</span>
            </div>
            <svg 
                class="user-profile-arrow" 
                :class="{ 'rotate-180': profileMenuOpen }" 
                fill="none" 
                stroke="currentColor" 
                viewBox="0 0 24 24"
            >
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </button>

        {{-- Menú Desplegable --}}
        <div 
            x-show="profileMenuOpen"
            x-cloak
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 transform scale-95 translate-y-[-10px]"
            x-transition:enter-end="opacity-100 transform scale-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 transform scale-100 translate-y-0"
            x-transition:leave-end="opacity-0 transform scale-95 translate-y-[-10px]"
            class="user-profile-dropdown"
            style="width: 280px !important; max-width: 280px !important; min-width: 280px !important;"
        >
            {{-- Información del Usuario --}}
            <div class="user-profile-header">
                <div class="user-profile-header-avatar">
                    <span class="user-profile-header-initials">{{ $initials }}</span>
                </div>
                <div class="user-profile-header-info">
                    <p class="user-profile-name">{{ Auth::user()->name }}</p>
                    <p class="user-profile-email">{{ Auth::user()->email }}</p>
                    <span class="user-profile-role">{{ Auth::user()->role === 'admin' ? 'Administrador' : 'Cliente' }}</span>
                </div>
            </div>

            <div class="user-profile-divider"></div>

            {{-- Opciones del Menú --}}
            <ul class="user-profile-menu-list">
                <li>
                    <a 
                        href="{{ route('dashboard') }}" 
                        class="user-profile-menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                        @click="profileMenuOpen = false"
                    >
                        <svg class="user-profile-menu-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                            <path d="M16 3h6v4"></path>
                            <path d="m22 7-10-4-10 4"></path>
                        </svg>
                        <span>Panel de Control</span>
                    </a>
                </li>
                <li>
                    <a 
                        href="{{ route('quotes.index') }}" 
                        class="user-profile-menu-item {{ request()->routeIs('quotes.*') ? 'active' : '' }}"
                        @click="profileMenuOpen = false"
                    >
                        <svg class="user-profile-menu-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                        <span>Mis Cotizaciones</span>
                    </a>
                </li>
                <li>
                    <a 
                        href="{{ route('packages.index') }}" 
                        class="user-profile-menu-item {{ request()->routeIs('packages.*') ? 'active' : '' }}"
                        @click="profileMenuOpen = false"
                    >
                        <svg class="user-profile-menu-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                        </svg>
                        <span>Mis Paquetes</span>
                    </a>
                </li>

                @if(Auth::user()->role === 'admin')
                    <div class="user-profile-divider"></div>
                    <li>
                        <p class="user-profile-menu-section">Administración</p>
                    </li>
                    <li>
                        <a 
                            href="{{ route('admin.users.index') }}" 
                            class="user-profile-menu-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}"
                            @click="profileMenuOpen = false"
                        >
                            <svg class="user-profile-menu-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                            <span>Usuarios</span>
                        </a>
                    </li>
                    <li>
                        <a 
                            href="{{ route('admin.logos.index') }}" 
                            class="user-profile-menu-item {{ request()->routeIs('admin.logos.*') ? 'active' : '' }}"
                            @click="profileMenuOpen = false"
                        >
                            <svg class="user-profile-menu-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span>Logotipos</span>
                        </a>
                    </li>
                    <li>
                        <a 
                            href="{{ route('admin.products.index') }}" 
                            class="user-profile-menu-item {{ request()->routeIs('admin.products.*') ? 'active' : '' }}"
                            @click="profileMenuOpen = false"
                        >
                            <svg class="user-profile-menu-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                            <span>Productos</span>
                        </a>
                    </li>
                @endif
            </ul>

            <div class="user-profile-divider"></div>

            {{-- Cerrar Sesión --}}
            <form method="POST" action="{{ route('logout') }}" class="user-profile-logout-form">
                @csrf
                <button 
                    type="submit" 
                    class="user-profile-logout-button"
                    @click="profileMenuOpen = false"
                >
                    <svg class="user-profile-menu-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                    <span>Cerrar Sesión</span>
                </button>
            </form>
        </div>
    </div>

    <style>
        .user-profile-menu {
            position: fixed;
            top: 30px;
            right: 30px;
            z-index: 1002;
        }

        .user-profile-button {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 12px;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .user-profile-button:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .user-profile-button.active {
            background: rgba(255, 255, 255, 0.25);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        .user-profile-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }

        .user-profile-initials {
            color: white;
            font-weight: 600;
            font-size: 14px;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
        }

        .user-profile-arrow {
            width: 16px;
            height: 16px;
            color: var(--theme-text-color, white);
            transition: transform 0.3s ease;
        }

        .user-profile-dropdown {
            position: absolute !important;
            top: calc(100% + 12px) !important;
            right: 0 !important;
            width: 280px !important;
            min-width: 280px !important;
            max-width: 280px !important;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 16px;
            box-shadow: 
                0 20px 40px rgba(0, 0, 0, 0.15),
                inset 0 1px 0 rgba(255, 255, 255, 0.2);
            overflow: hidden;
            z-index: 10000;
            box-sizing: border-box;
        }

        .user-profile-header {
            padding: 16px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-profile-header-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            flex-shrink: 0;
        }

        .user-profile-header-initials {
            color: white;
            font-weight: 600;
            font-size: 18px;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
        }

        .user-profile-header-info {
            flex: 1;
            min-width: 0;
        }

        .user-profile-name {
            color: var(--theme-text-color, white);
            font-weight: 600;
            font-size: 15px;
            margin: 0 0 4px 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .user-profile-email {
            color: var(--theme-text-secondary-color, rgba(255, 255, 255, 0.8));
            font-size: 13px;
            margin: 0 0 6px 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .user-profile-role {
            display: inline-block;
            padding: 2px 8px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            color: var(--theme-text-color, white);
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .user-profile-divider {
            height: 1px;
            background: rgba(255, 255, 255, 0.1);
            margin: 8px 0;
        }

        .user-profile-menu-list {
            list-style: none;
            margin: 0;
            padding: 8px 0;
        }

        .user-profile-menu-section {
            padding: 8px 16px;
            color: var(--theme-text-secondary-color, rgba(255, 255, 255, 0.7));
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin: 0;
        }

        .user-profile-menu-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            color: var(--theme-text-color, white);
            text-decoration: none;
            transition: all 0.2s ease;
            font-size: 14px;
        }

        .user-profile-menu-item:hover {
            background: rgba(255, 255, 255, 0.15);
        }

        .user-profile-menu-item.active {
            background: rgba(255, 255, 255, 0.2);
            border-left: 3px solid rgba(255, 255, 255, 0.5);
        }

        .user-profile-menu-icon {
            width: 18px;
            height: 18px;
            stroke-width: 2;
            flex-shrink: 0;
        }

        .user-profile-logout-form {
            padding: 8px;
        }

        .user-profile-logout-button {
            width: 100%;
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            background: rgba(239, 68, 68, 0.2);
            border: 1px solid rgba(239, 68, 68, 0.3);
            border-radius: 12px;
            color: #fecaca;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .user-profile-logout-button:hover {
            background: rgba(239, 68, 68, 0.3);
            border-color: rgba(239, 68, 68, 0.5);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.2);
        }

        @media (max-width: 768px) {
            .user-profile-menu {
                display: none;
            }
        }
    </style>
@endauth

