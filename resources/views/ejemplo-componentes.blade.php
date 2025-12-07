{{-- 
    Ejemplo de uso de componentes UI con estrategia mobile-first
    Esta vista demuestra cómo usar los componentes modulares
--}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-gray-800 leading-tight">
            Ejemplo de Componentes UI
        </h2>
    </x-slot>

    <x-ui.container>
        {{-- Ejemplo de Grid Responsivo --}}
        <div class="mb-6 sm:mb-8">
            <h3 class="text-lg sm:text-xl font-semibold mb-4">Grid Responsivo</h3>
            <x-ui.grid :cols="1" :cols-sm="2" :cols-md="3" gap="default">
                <x-ui.card>
                    <h4 class="font-semibold mb-2">Card 1</h4>
                    <p class="text-sm text-gray-600">Contenido de la tarjeta 1. En móvil ocupa todo el ancho, en tablet 2 columnas, en desktop 3 columnas.</p>
                </x-ui.card>
                <x-ui.card>
                    <h4 class="font-semibold mb-2">Card 2</h4>
                    <p class="text-sm text-gray-600">Contenido de la tarjeta 2. El espaciado se ajusta automáticamente según el tamaño de pantalla.</p>
                </x-ui.card>
                <x-ui.card>
                    <h4 class="font-semibold mb-2">Card 3</h4>
                    <p class="text-sm text-gray-600">Contenido de la tarjeta 3. Los componentes siguen la filosofía mobile-first.</p>
                </x-ui.card>
            </x-ui.grid>
        </div>

        {{-- Ejemplo de Botones Responsivos --}}
        <div class="mb-6 sm:mb-8">
            <h3 class="text-lg sm:text-xl font-semibold mb-4">Botones Responsivos</h3>
            <div class="flex flex-col sm:flex-row gap-3 sm:gap-4">
                <x-ui.button variant="primary" full-width class="sm:w-auto">
                    Botón Primario
                </x-ui.button>
                <x-ui.button variant="secondary" full-width class="sm:w-auto">
                    Botón Secundario
                </x-ui.button>
                <x-ui.button variant="outline" full-width class="sm:w-auto">
                    Botón Outline
                </x-ui.button>
            </div>
        </div>

        {{-- Ejemplo de Formulario Responsivo --}}
        <div class="mb-6 sm:mb-8">
            <h3 class="text-lg sm:text-xl font-semibold mb-4">Formulario Responsivo</h3>
            <x-ui.card>
                <form>
                    <x-ui.form-group name="nombre" label="Nombre">
                        <x-text-input type="text" name="nombre" placeholder="Ingresa tu nombre" />
                    </x-ui.form-group>

                    <x-ui.form-group name="email" label="Email">
                        <x-text-input type="email" name="email" placeholder="tu@email.com" />
                    </x-ui.form-group>

                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-end gap-3 sm:gap-4 mt-6">
                        <x-ui.button variant="secondary" full-width class="sm:w-auto">
                            Cancelar
                        </x-ui.button>
                        <x-ui.button variant="primary" full-width class="sm:w-auto">
                            Enviar
                        </x-ui.button>
                    </div>
                </form>
            </x-ui.card>
        </div>
    </x-ui.container>
</x-app-layout>
