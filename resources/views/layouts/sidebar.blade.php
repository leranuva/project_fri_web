{{-- Sidebar Navigation --}}
<div class="h-full flex flex-col">
    {{-- Logo --}}
    <div class="flex items-center justify-between h-16 px-4 border-b border-gray-200">
        <a href="{{ route('home') }}" class="flex items-center">
            <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg flex items-center justify-center mr-2">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
            </div>
            <span class="text-lg font-semibold text-gray-800">Flat Rate Imports</span>
        </a>
    </div>


    {{-- User Section --}}
    @auth
        <div class="px-4 py-4 border-t border-gray-200">
            <div class="flex items-center mb-4">
                <div class="flex-shrink-0">
                    <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                        <span class="text-gray-600 font-medium text-sm">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </span>
                    </div>
                </div>
                <div class="ml-3 flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900 truncate">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                </div>
            </div>

            <div class="space-y-1">
                <a 
                    href="{{ route('profile.edit') }}" 
                    class="block px-3 py-2 text-sm text-gray-700 rounded-md hover:bg-gray-100 transition"
                >
                    {{ __('Profile') }}
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button 
                        type="submit"
                        class="block w-full text-left px-3 py-2 text-sm text-gray-700 rounded-md hover:bg-gray-100 transition"
                    >
                        {{ __('Log Out') }}
                    </button>
                </form>
            </div>
        </div>
    @else
        <div class="px-4 py-4 border-t border-gray-200">
            <div class="space-y-2">
                <a 
                    href="{{ route('login') }}" 
                    class="block w-full text-center px-3 py-2 text-sm font-medium text-blue-600 bg-blue-50 rounded-md hover:bg-blue-100 transition"
                >
                    Iniciar Sesión
                </a>
                <a 
                    href="{{ route('register') }}" 
                    class="block w-full text-center px-3 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 transition"
                >
                    Registrarse
                </a>
            </div>
        </div>
    @endauth
</div>
