{{-- Barra de Navegación Superior (solo visible en móvil/tablet, oculta en desktop con sidebar) --}}
<nav class="lg:hidden bg-white border-b border-gray-100">
    <x-ui.container>
        <div class="flex justify-between items-center h-14 sm:h-16">
            {{-- Logo y Toggle Sidebar --}}
            <div class="flex items-center">
                <button 
                    @click="sidebarOpen = !sidebarOpen"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out"
                >
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                
                <a href="{{ route('home') }}" class="ml-3">
                    <x-application-logo class="block h-8 w-auto fill-current text-gray-800" />
                </a>
            </div>

            {{-- User Menu Dropdown o Botones de Login/Registro --}}
            <div class="flex items-center gap-2">
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                <div class="h-8 w-8 rounded-full bg-gray-300 flex items-center justify-center">
                                    <span class="text-gray-600 font-medium text-xs">
                                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                    </span>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <a 
                        href="{{ route('login') }}" 
                        class="px-3 py-2 text-sm font-medium text-gray-700 hover:text-gray-900 transition"
                    >
                        Iniciar Sesión
                    </a>
                    <a 
                        href="{{ route('register') }}" 
                        class="px-3 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 transition"
                    >
                        Registrarse
                    </a>
                @endauth
            </div>
        </div>
    </x-ui.container>
</nav>
