<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-white leading-tight">
            {{ __('Guía Interactiva del Dashboard') }}
        </h2>
    </x-slot>

    <x-ui.container>
        {{-- Contenedor principal de la guía --}}
        <div x-data="dashboardGuide()" x-init="init()" class="guide-container">
            {{-- Barra de progreso --}}
            <div class="mb-6">
                <x-ui.card glassmorphism="true" padding="lg">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h1 class="text-2xl sm:text-3xl font-bold text-white mb-2">
                                Guía Interactiva del Dashboard
                            </h1>
                            <p class="text-sm sm:text-base text-white/80">
                                Aprende a usar todas las funciones del panel de administración paso a paso
                            </p>
                        </div>
                        <button 
                            @click="startTour()" 
                            class="glass-button glass-button-sm sm:glass-button flex items-center gap-2"
                            :disabled="tourActive"
                        >
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span x-show="!tourActive">Iniciar Tour</span>
                            <span x-show="tourActive">Tour en Curso...</span>
                        </button>
                    </div>
                    
                    {{-- Barra de progreso --}}
                    <div x-show="tourActive" class="mt-4">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm text-white/80">Paso <span x-text="currentStep + 1"></span> de <span x-text="steps.length"></span></span>
                            <span class="text-sm text-white/80" x-text="Math.round(((currentStep + 1) / steps.length) * 100) + '%'"></span>
                        </div>
                        <div class="w-full bg-white/10 rounded-full h-2 overflow-hidden">
                            <div 
                                class="bg-gradient-to-r from-blue-500 to-purple-500 h-2 rounded-full transition-all duration-500 ease-out"
                                :style="'width: ' + ((currentStep + 1) / steps.length) * 100 + '%'"
                            ></div>
                        </div>
                    </div>
                </x-ui.card>
            </div>

            {{-- Contenido de la guía --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- Panel de navegación de secciones --}}
                <div class="lg:col-span-1">
                    <x-ui.card glassmorphism="true" padding="lg" class="sticky top-4">
                        <h3 class="text-lg font-semibold text-white mb-4">Secciones de la Guía</h3>
                        <nav class="space-y-2">
                            <template x-for="(step, index) in steps" :key="index">
                                <button
                                    @click="goToStep(index)"
                                    class="w-full text-left p-3 rounded-lg transition-all duration-200"
                                    :class="currentStep === index ? 'bg-white/20 border-2 border-blue-400' : 'bg-white/10 hover:bg-white/15 border border-white/20'"
                                    :disabled="tourActive && currentStep !== index"
                                >
                                    <div class="flex items-center gap-3">
                                        <div 
                                            class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-semibold"
                                            :class="currentStep === index ? 'bg-blue-500 text-white' : 'bg-white/20 text-white/70'"
                                            x-text="index + 1"
                                        ></div>
                                        <div class="flex-1">
                                            <p class="text-sm font-medium text-white" x-text="step.title"></p>
                                            <p class="text-xs text-white/60" x-text="step.category"></p>
                                        </div>
                                        <svg 
                                            x-show="currentStep === index" 
                                            class="w-5 h-5 text-blue-400 animate-pulse" 
                                            fill="currentColor" 
                                            viewBox="0 0 20 20"
                                        >
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </template>
                        </nav>
                    </x-ui.card>
                </div>

                {{-- Contenido principal de la guía --}}
                <div class="lg:col-span-2">
                    <div class="space-y-6">
                        <template x-for="(step, index) in steps" :key="index">
                            <div 
                                x-show="currentStep === index"
                                x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0 transform translate-y-4"
                                x-transition:enter-end="opacity-100 transform translate-y-0"
                                x-transition:leave="transition ease-in duration-200"
                                x-transition:leave-start="opacity-100 transform translate-y-0"
                                x-transition:leave-end="opacity-0 transform -translate-y-4"
                            >
                                <x-ui.card glassmorphism="true" padding="lg" class="guide-step-card">
                                    <div class="mb-6">
                                        <div class="flex items-center gap-3 mb-4">
                                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500/30 to-purple-500/30 backdrop-blur-sm border border-white/20 flex items-center justify-center">
                                                <span class="text-2xl font-bold text-white" x-text="index + 1"></span>
                                            </div>
                                            <div class="flex-1">
                                                <h2 class="text-xl sm:text-2xl font-bold text-white mb-1" x-text="step.title"></h2>
                                                <p class="text-sm text-white/60" x-text="step.category"></p>
                                            </div>
                                        </div>
                                        
                                        <div class="prose prose-invert max-w-none">
                                            <div class="text-white/90 space-y-4" x-html="step.content"></div>
                                        </div>
                                    </div>

                                    {{-- Imagen o ejemplo visual --}}
                                    <div x-show="step.image" class="mb-6 rounded-xl overflow-hidden border border-white/20">
                                        <img :src="step.image" :alt="step.title" class="w-full h-auto">
                                    </div>

                                    {{-- Botones de navegación --}}
                                    <div class="flex items-center justify-between pt-6 border-t border-white/10">
                                        <button
                                            @click="previousStep()"
                                            :disabled="currentStep === 0"
                                            class="glass-button glass-button-sm flex items-center gap-2"
                                            :class="currentStep === 0 ? 'opacity-50 cursor-not-allowed' : ''"
                                        >
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                            </svg>
                                            <span>Anterior</span>
                                        </button>
                                        
                                        <div class="flex gap-2">
                                            <button
                                                @click="pauseTour()"
                                                x-show="tourActive"
                                                class="glass-button glass-button-sm flex items-center gap-2"
                                                style="background: rgba(255, 193, 7, 0.2);"
                                            >
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zM7 8a1 1 0 012 0v4a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v4a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                </svg>
                                                <span>Pausar</span>
                                            </button>
                                        </div>
                                        
                                        <button
                                            @click="nextStep()"
                                            :disabled="currentStep === steps.length - 1"
                                            class="glass-button glass-button-sm flex items-center gap-2"
                                            :class="currentStep === steps.length - 1 ? 'opacity-50 cursor-not-allowed' : ''"
                                        >
                                            <span x-show="currentStep < steps.length - 1">Siguiente</span>
                                            <span x-show="currentStep === steps.length - 1">Finalizar</span>
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                            </svg>
                                        </button>
                                    </div>
                                </x-ui.card>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </x-ui.container>

    <style>
        .guide-container {
            min-height: calc(100vh - 200px);
        }
        
        .guide-step-card {
            animation: slideIn 0.5s ease-out;
        }
        
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .prose {
            color: rgba(255, 255, 255, 0.9);
        }
        
        .prose h3 {
            color: white;
            font-size: 1.25rem;
            font-weight: 600;
            margin-top: 1.5rem;
            margin-bottom: 0.75rem;
        }
        
        .prose ul {
            list-style-type: disc;
            padding-left: 1.5rem;
            margin-top: 0.75rem;
            margin-bottom: 0.75rem;
        }
        
        .prose li {
            margin-top: 0.5rem;
            margin-bottom: 0.5rem;
        }
        
        .prose code {
            background: rgba(255, 255, 255, 0.1);
            padding: 0.125rem 0.375rem;
            border-radius: 0.25rem;
            font-size: 0.875em;
        }
    </style>

    <script>
        function dashboardGuide() {
            return {
                currentStep: 0,
                tourActive: false,
                autoPlayInterval: null,
                steps: [
                    {
                        title: 'Bienvenida al Dashboard',
                        category: 'Introducción',
                        content: `
                            <p class="text-lg mb-4">¡Bienvenido al panel de administración de Flat Rate Imports!</p>
                            <p>Este dashboard te permite gestionar todos los aspectos de tu plataforma de importaciones. Desde aquí podrás:</p>
                            <ul>
                                <li>Gestionar usuarios y permisos</li>
                                <li>Configurar productos y tarifas</li>
                                <li>Personalizar el diseño y contenido del sitio</li>
                                <li>Monitorear estadísticas y actividad</li>
                            </ul>
                            <p class="mt-4"><strong>💡 Tip:</strong> Usa el botón "Iniciar Tour" para una guía interactiva paso a paso, o navega manualmente usando el menú lateral.</p>
                        `,
                        image: null
                    },
                    {
                        title: 'Panel de Estadísticas',
                        category: 'Dashboard Principal',
                        content: `
                            <p>En la parte superior del dashboard encontrarás un panel con estadísticas clave:</p>
                            <ul>
                                <li><strong>Usuarios Totales:</strong> Número total de usuarios registrados</li>
                                <li><strong>Administradores:</strong> Cantidad de usuarios con rol de administrador</li>
                                <li><strong>Clientes:</strong> Número de usuarios con rol de cliente</li>
                                <li><strong>Productos:</strong> Total de productos configurados en el sistema</li>
                            </ul>
                            <p class="mt-4">Estas estadísticas se actualizan automáticamente y te dan una visión general rápida del estado de tu plataforma.</p>
                        `,
                        image: null
                    },
                    {
                        title: 'Estado de la Cuenta',
                        category: 'Información Personal',
                        content: `
                            <p>La tarjeta de "Estado de la Cuenta" muestra información importante sobre tu perfil:</p>
                            <ul>
                                <li><strong>Email verificado:</strong> Indica si tu correo electrónico ha sido verificado</li>
                                <li><strong>Cuenta creada:</strong> Fecha en que se creó tu cuenta</li>
                            </ul>
                            <p class="mt-4">Desde aquí puedes acceder a tu perfil para editar tu información personal, cambiar tu contraseña, o actualizar tus preferencias.</p>
                            <p class="mt-2"><strong>🔗 Acceso rápido:</strong> Haz clic en "Ver Perfil" para ir directamente a la configuración de tu cuenta.</p>
                        `,
                        image: null
                    },
                    {
                        title: 'Acciones Rápidas',
                        category: 'Navegación',
                        content: `
                            <p>La sección de "Acciones Rápidas" te permite acceder rápidamente a las funciones más utilizadas:</p>
                            <ul>
                                <li><strong>Crear Cotización:</strong> Acceso directo al cotizador de importaciones</li>
                                <li><strong>Ir al Inicio:</strong> Volver a la página principal del sitio</li>
                            </ul>
                            <p class="mt-4"><strong>Para Administradores:</strong> Verás una sección adicional con todas las opciones de administración organizadas por categorías.</p>
                        `,
                        image: null
                    },
                    {
                        title: 'Gestión de Usuarios',
                        category: 'Administración',
                        content: `
                            <p>Desde "Usuarios" puedes gestionar todos los usuarios del sistema:</p>
                            <ul>
                                <li><strong>Ver lista de usuarios:</strong> Consulta todos los usuarios registrados</li>
                                <li><strong>Crear nuevo usuario:</strong> Agrega usuarios manualmente</li>
                                <li><strong>Editar usuarios:</strong> Modifica información, roles y permisos</li>
                                <li><strong>Eliminar usuarios:</strong> Elimina cuentas que ya no necesites</li>
                            </ul>
                            <p class="mt-4"><strong>⚠️ Importante:</strong> Solo los administradores pueden gestionar usuarios. Los roles disponibles son: <code>admin</code> y <code>customer</code>.</p>
                        `,
                        image: null
                    },
                    {
                        title: 'Gestión de Productos',
                        category: 'Configuración',
                        content: `
                            <p>Los productos son los artículos que se pueden importar. Desde aquí puedes:</p>
                            <ul>
                                <li><strong>Agregar productos:</strong> Define nuevos productos con sus características</li>
                                <li><strong>Configurar impuestos:</strong> Establece el Ad-Valorem y Arancel Específico para cada producto</li>
                                <li><strong>Activar/Desactivar:</strong> Controla qué productos están disponibles en el cotizador</li>
                                <li><strong>Ordenar productos:</strong> Define el orden de aparición en las listas</li>
                            </ul>
                            <p class="mt-4"><strong>💡 Tip:</strong> Los productos activos aparecerán automáticamente en el cotizador para que los clientes los seleccionen.</p>
                        `,
                        image: null
                    },
                    {
                        title: 'Tarifas de Envío',
                        category: 'Configuración',
                        content: `
                            <p>Las tarifas de envío determinan el costo del transporte según el método seleccionado:</p>
                            <ul>
                                <li><strong>Métodos disponibles:</strong> Marítimo, Aéreo, Aéreo Express, Courier 4x4</li>
                                <li><strong>Configurar por peso:</strong> Define tarifas según rangos de peso (lb)</li>
                                <li><strong>Precios por libra:</strong> Establece el costo por libra para cada rango</li>
                                <li><strong>Activar/Desactivar:</strong> Controla qué métodos están disponibles</li>
                            </ul>
                            <p class="mt-4"><strong>📊 Ejemplo:</strong> Puedes configurar que de 1-5 lbs el costo sea $X por libra, de 6-10 lbs sea $Y, etc.</p>
                        `,
                        image: null
                    },
                    {
                        title: 'Impuestos y Tasas',
                        category: 'Configuración',
                        content: `
                            <p>Desde "Impuestos" puedes gestionar las tasas impositivas aplicadas a las importaciones:</p>
                            <ul>
                                <li><strong>Ad-Valorem:</strong> Impuesto basado en el valor del producto</li>
                                <li><strong>FODINFA:</strong> Fondo de Desarrollo e Inversión del Sector Eléctrico</li>
                                <li><strong>IVA:</strong> Impuesto al Valor Agregado</li>
                            </ul>
                            <p class="mt-4"><strong>⚙️ Configuración:</strong> Puedes establecer tasas globales o específicas por producto. Los cambios se aplican automáticamente a las nuevas cotizaciones.</p>
                        `,
                        image: null
                    },
                    {
                        title: 'Slider Principal',
                        category: 'Contenido',
                        content: `
                            <p>El slider principal es la primera sección que ven los visitantes en la página de inicio:</p>
                            <ul>
                                <li><strong>Agregar slides:</strong> Crea nuevas imágenes o contenido para el carrusel</li>
                                <li><strong>Editar contenido:</strong> Modifica títulos, descripciones y enlaces</li>
                                <li><strong>Ordenar slides:</strong> Define el orden de aparición</li>
                                <li><strong>Activar/Desactivar:</strong> Controla qué slides se muestran</li>
                            </ul>
                            <p class="mt-4"><strong>🎨 Diseño:</strong> Puedes agregar imágenes, títulos llamativos y botones de acción para crear una primera impresión impactante.</p>
                        `,
                        image: null
                    },
                    {
                        title: 'Pasos del Proceso',
                        category: 'Contenido',
                        content: `
                            <p>Los "Pasos del Proceso" explican a los clientes cómo funciona tu servicio:</p>
                            <ul>
                                <li><strong>Crear pasos:</strong> Define cada etapa del proceso de importación</li>
                                <li><strong>Agregar iconos:</strong> Usa iconos SVG para hacer los pasos más visuales</li>
                                <li><strong>Descripciones:</strong> Explica claramente qué sucede en cada paso</li>
                                <li><strong>Ordenar:</strong> Define la secuencia lógica del proceso</li>
                            </ul>
                            <p class="mt-4"><strong>📝 Tip:</strong> Mantén las descripciones claras y concisas. Los clientes deben entender fácilmente el proceso.</p>
                        `,
                        image: null
                    },
                    {
                        title: 'Configurar "¿Cómo Funciona?"',
                        category: 'Contenido',
                        content: `
                            <p>Esta sección permite personalizar completamente la sección "¿Cómo Funciona?" de la página de inicio:</p>
                            <ul>
                                <li><strong>Título y subtítulo:</strong> Personaliza los textos principales</li>
                                <li><strong>Colores:</strong> Define los colores del título, subtítulo y botones</li>
                                <li><strong>Texto del pie:</strong> Agrega información adicional al final</li>
                                <li><strong>Botón de acción:</strong> Configura el texto y enlace del botón principal</li>
                            </ul>
                            <p class="mt-4"><strong>🎨 Personalización:</strong> Puedes hacer que esta sección coincida perfectamente con la identidad visual de tu marca.</p>
                        `,
                        image: null
                    },
                    {
                        title: 'Banner de Alerta',
                        category: 'Contenido',
                        content: `
                            <p>El banner de alerta permite mostrar mensajes importantes en la parte superior del sitio:</p>
                            <ul>
                                <li><strong>Crear alertas:</strong> Agrega mensajes de notificación o advertencia</li>
                                <li><strong>Tipos de alerta:</strong> Info, Advertencia, Error, Éxito</li>
                                <li><strong>Activar/Desactivar:</strong> Controla cuándo se muestra el banner</li>
                                <li><strong>Fechas:</strong> Programa alertas para fechas específicas</li>
                            </ul>
                            <p class="mt-4"><strong>📢 Uso común:</strong> Anunciar promociones, cambios en el servicio, o información importante para los clientes.</p>
                        `,
                        image: null
                    },
                    {
                        title: 'Beneficios',
                        category: 'Contenido',
                        content: `
                            <p>La sección de beneficios destaca las ventajas de usar tu servicio:</p>
                            <ul>
                                <li><strong>Agregar beneficios:</strong> Crea nuevas ventajas o características</li>
                                <li><strong>Iconos:</strong> Usa iconos SVG para hacer los beneficios más atractivos</li>
                                <li><strong>Títulos y descripciones:</strong> Explica claramente cada beneficio</li>
                                <li><strong>Ordenar:</strong> Define qué beneficios aparecen primero</li>
                            </ul>
                            <p class="mt-4"><strong>💎 Tip:</strong> Destaca los beneficios más importantes primero. Los clientes deben ver rápidamente por qué elegir tu servicio.</p>
                        `,
                        image: null
                    },
                    {
                        title: 'Paquetes / Tracking',
                        category: 'Gestión',
                        content: `
                            <p>Desde "Paquetes" puedes gestionar el seguimiento de envíos:</p>
                            <ul>
                                <li><strong>Registrar paquetes:</strong> Agrega nuevos paquetes con su información</li>
                                <li><strong>Números de tracking:</strong> Asigna códigos de seguimiento</li>
                                <li><strong>Estados:</strong> Actualiza el estado de cada paquete (En tránsito, Entregado, etc.)</li>
                                <li><strong>Asociar con usuarios:</strong> Vincula paquetes a clientes específicos</li>
                            </ul>
                            <p class="mt-4"><strong>📦 Funcionalidad:</strong> Los clientes pueden consultar el estado de sus paquetes usando el número de tracking.</p>
                        `,
                        image: null
                    },
                    {
                        title: 'Gestión de Tiendas',
                        category: 'Contenido',
                        content: `
                            <p>La sección de tiendas muestra los logos de las tiendas donde los clientes pueden comprar:</p>
                            <ul>
                                <li><strong>Agregar tiendas:</strong> Crea nuevas entradas con logos SVG</li>
                                <li><strong>Código SVG:</strong> Pega el código SVG completo del logo</li>
                                <li><strong>Enlaces:</strong> Agrega enlaces a las tiendas</li>
                                <li><strong>Ordenar:</strong> Define el orden de aparición en la página</li>
                            </ul>
                            <p class="mt-4"><strong>🛍️ Configuración:</strong> Puedes personalizar el título y subtítulo de la sección "Compra en todas estas tiendas" desde "Configurar Sección de Tiendas".</p>
                        `,
                        image: null
                    },
                    {
                        title: 'Temas de Interés (Blog)',
                        category: 'Contenido',
                        content: `
                            <p>El blog permite publicar artículos y temas de interés para tus clientes:</p>
                            <ul>
                                <li><strong>Crear artículos:</strong> Publica nuevos posts con título, contenido e imágenes</li>
                                <li><strong>Gestionar sección:</strong> Configura el título y colores de la sección de blog</li>
                                <li><strong>Fechas de publicación:</strong> Programa artículos para fechas futuras</li>
                                <li><strong>Activar/Desactivar:</strong> Controla qué artículos se muestran</li>
                            </ul>
                            <p class="mt-4"><strong>📝 Contenido:</strong> Usa el blog para compartir consejos, noticias, o información relevante sobre importaciones.</p>
                        `,
                        image: null
                    },
                    {
                        title: 'Footer (Pie de Página)',
                        category: 'Contenido',
                        content: `
                            <p>El footer aparece en todas las páginas del sitio. Puedes gestionar:</p>
                            <ul>
                                <li><strong>Enlaces del footer:</strong> Agrega enlaces de navegación (Inicio, Cotizador, etc.)</li>
                                <li><strong>Redes sociales:</strong> Configura iconos y enlaces a tus redes sociales</li>
                                <li><strong>Configuración general:</strong> Personaliza el nombre de la marca y texto de copyright</li>
                                <li><strong>Iconos SVG:</strong> Usa código SVG personalizado para los iconos de redes sociales</li>
                            </ul>
                            <p class="mt-4"><strong>🔗 Organización:</strong> Los enlaces se organizan automáticamente. Puedes definir el orden de aparición.</p>
                        `,
                        image: null
                    },
                    {
                        title: 'Configuración del Cotizador',
                        category: 'Configuración',
                        content: `
                            <p>Personaliza completamente la apariencia y contenido del cotizador:</p>
                            <ul>
                                <li><strong>Título y descripción:</strong> Define los textos que aparecen en el cotizador</li>
                                <li><strong>Colores personalizados:</strong> Configura colores para:
                                    <ul class="ml-4 mt-2">
                                        <li>Título principal</li>
                                        <li>Títulos de sección</li>
                                        <li>Labels de cada campo (Producto, Cantidad, Peso, Valor, Método de envío)</li>
                                    </ul>
                                </li>
                                <li><strong>Activar/Desactivar:</strong> Controla si el cotizador está disponible</li>
                            </ul>
                            <p class="mt-4"><strong>🎨 Personalización:</strong> Haz que el cotizador coincida perfectamente con el diseño de tu sitio.</p>
                        `,
                        image: null
                    },
                    {
                        title: 'Gestión de Temas',
                        category: 'Diseño',
                        content: `
                            <p>Los temas controlan los colores y el diseño general de todo el sitio:</p>
                            <ul>
                                <li><strong>Crear temas:</strong> Diseña nuevos esquemas de color</li>
                                <li><strong>Colores del tema:</strong> Configura colores principales, secundarios y de acento</li>
                                <li><strong>Gradientes:</strong> Define gradientes de fondo personalizados</li>
                                <li><strong>Colores de texto y botones:</strong> Ajusta los colores de los textos y elementos interactivos</li>
                                <li><strong>Activar tema:</strong> Solo un tema puede estar activo a la vez</li>
                            </ul>
                            <p class="mt-4"><strong>🎨 Temas disponibles:</strong> Tema Púrpura (por defecto), Tema Azul, Tema Verde, y Tema Dance Studio. Puedes crear tantos temas como necesites.</p>
                            <p class="mt-2"><strong>💡 Tip:</strong> Cambia de tema para ver cómo se ve tu sitio con diferentes esquemas de color antes de hacerlo público.</p>
                        `,
                        image: null
                    },
                    {
                        title: 'Consejos Finales',
                        category: 'Mejores Prácticas',
                        content: `
                            <p class="text-lg mb-4">¡Felicidades! Has completado la guía del dashboard. Aquí tienes algunos consejos finales:</p>
                            <ul>
                                <li><strong>🔄 Actualiza regularmente:</strong> Mantén el contenido fresco y actualizado</li>
                                <li><strong>📊 Revisa estadísticas:</strong> Monitorea las métricas del dashboard para entender el uso de tu plataforma</li>
                                <li><strong>🎨 Experimenta con temas:</strong> Prueba diferentes temas para encontrar el que mejor represente tu marca</li>
                                <li><strong>📝 Contenido claro:</strong> Asegúrate de que toda la información sea clara y fácil de entender</li>
                                <li><strong>🔒 Seguridad:</strong> Solo comparte acceso de administrador con personas de confianza</li>
                            </ul>
                            <p class="mt-4"><strong>❓ ¿Necesitas ayuda?</strong> Puedes volver a esta guía en cualquier momento desde el dashboard. También puedes revisar cada sección individualmente para más detalles.</p>
                            <p class="mt-2"><strong>🚀 ¡Listo para comenzar!</strong> Ahora tienes todo el conocimiento necesario para gestionar tu plataforma de importaciones.</p>
                        `,
                        image: null
                    }
                ],
                
                init() {
                    // Inicialización
                },
                
                startTour() {
                    this.tourActive = true;
                    this.currentStep = 0;
                    this.autoPlay();
                    this.scrollToTop();
                },
                
                pauseTour() {
                    this.tourActive = false;
                    if (this.autoPlayInterval) {
                        clearInterval(this.autoPlayInterval);
                        this.autoPlayInterval = null;
                    }
                },
                
                autoPlay() {
                    if (this.autoPlayInterval) {
                        clearInterval(this.autoPlayInterval);
                    }
                    
                    this.autoPlayInterval = setInterval(() => {
                        if (this.currentStep < this.steps.length - 1) {
                            this.nextStep();
                        } else {
                            this.pauseTour();
                        }
                    }, 10000); // Cambia cada 10 segundos
                },
                
                nextStep() {
                    if (this.currentStep < this.steps.length - 1) {
                        this.currentStep++;
                        this.scrollToTop();
                    }
                },
                
                previousStep() {
                    if (this.currentStep > 0) {
                        this.currentStep--;
                        this.scrollToTop();
                    }
                },
                
                goToStep(index) {
                    if (!this.tourActive || this.currentStep === index) {
                        this.currentStep = index;
                        this.scrollToTop();
                    }
                },
                
                scrollToTop() {
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                }
            }
        }
    </script>
</x-app-layout>

