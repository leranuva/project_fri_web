<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-white leading-tight">
            {{ __('Estimación de Costos del Proyecto') }}
        </h2>
    </x-slot>

    <x-ui.container>
        {{-- Contenedor principal de la presentación --}}
        <div x-data="projectCosts()" x-init="init()" class="costs-container">
            {{-- Barra de progreso --}}
            <div class="mb-6">
                <x-ui.card glassmorphism="true" padding="lg">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h1 class="text-2xl sm:text-3xl font-bold text-white mb-2">
                                💰 Estimación de Costos del Proyecto
                            </h1>
                            <p class="text-sm sm:text-base text-white/80">
                                Presentación interactiva de la valoración completa del sistema
                            </p>
                        </div>
                        <button 
                            @click="startPresentation()" 
                            class="glass-button glass-button-sm sm:glass-button flex items-center gap-2"
                            :disabled="presentationActive"
                        >
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span x-show="!presentationActive">Iniciar Presentación</span>
                            <span x-show="presentationActive">Presentación en Curso...</span>
                        </button>
                    </div>
                    
                    {{-- Barra de progreso --}}
                    <div x-show="presentationActive" class="mt-4">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm text-white/80">Sección <span x-text="currentStep + 1"></span> de <span x-text="steps.length"></span></span>
                            <span class="text-sm text-white/80" x-text="Math.round(((currentStep + 1) / steps.length) * 100) + '%'"></span>
                        </div>
                        <div class="w-full bg-white/10 rounded-full h-2 overflow-hidden">
                            <div 
                                class="bg-gradient-to-r from-green-500 to-blue-500 h-2 rounded-full transition-all duration-500 ease-out"
                                :style="'width: ' + ((currentStep + 1) / steps.length) * 100 + '%'"
                            ></div>
                        </div>
                    </div>
                </x-ui.card>
            </div>

            {{-- Contenido de la presentación --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- Panel de navegación de secciones --}}
                <div class="lg:col-span-1">
                    <x-ui.card glassmorphism="true" padding="lg" class="sticky top-4">
                        <h3 class="text-lg font-semibold text-white mb-4">Secciones</h3>
                        <nav class="space-y-2">
                            <template x-for="(step, index) in steps" :key="index">
                                <button
                                    @click="goToStep(index)"
                                    class="w-full text-left p-3 rounded-lg transition-all duration-200"
                                    :class="currentStep === index ? 'bg-white/20 border-2 border-green-400' : 'bg-white/10 hover:bg-white/15 border border-white/20'"
                                    :disabled="presentationActive && currentStep !== index"
                                >
                                    <div class="flex items-center gap-3">
                                        <div 
                                            class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-semibold"
                                            :class="currentStep === index ? 'bg-green-500 text-white' : 'bg-white/20 text-white/70'"
                                            x-text="index + 1"
                                        ></div>
                                        <div class="flex-1">
                                            <p class="text-sm font-medium text-white" x-text="step.title"></p>
                                            <p class="text-xs text-white/60" x-text="step.category"></p>
                                        </div>
                                        <svg 
                                            x-show="currentStep === index" 
                                            class="w-5 h-5 text-green-400 animate-pulse" 
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

                {{-- Contenido principal --}}
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
                                <x-ui.card glassmorphism="true" padding="lg" class="cost-step-card">
                                    <div class="mb-6">
                                        <div class="flex items-center gap-3 mb-4">
                                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-green-500/30 to-blue-500/30 backdrop-blur-sm border border-white/20 flex items-center justify-center">
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
                                                @click="pausePresentation()"
                                                x-show="presentationActive"
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
        .costs-container {
            min-height: calc(100vh - 200px);
        }
        
        .cost-step-card {
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
        
        .prose table {
            width: 100%;
            border-collapse: collapse;
            margin: 1rem 0;
        }
        
        .prose table th,
        .prose table td {
            padding: 0.75rem;
            text-align: left;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .prose table th {
            background: rgba(255, 255, 255, 0.1);
            font-weight: 600;
        }
    </style>

    <script>
        function projectCosts() {
            return {
                currentStep: 0,
                presentationActive: false,
                autoPlayInterval: null,
                steps: [
                    {
                        title: 'Resumen Ejecutivo',
                        category: 'Información General',
                        content: `
                            <p class="text-lg mb-4">💰 <strong>Estimación de Costos del Proyecto - Flat Rate Imports</strong></p>
                            <div class="bg-white/10 rounded-lg p-4 mb-4">
                                <p><strong>Proyecto:</strong> Sistema de Cotización de Importaciones</p>
                                <p><strong>Desarrollado por:</strong> Lenin Ramiro Nunez Valverde</p>
                                <p><strong>Período real:</strong> Enero 2023 - Diciembre 2024 (24 meses, 2-3 horas/noche)</p>
                                <p><strong>Horas estimadas:</strong> 1,440 - 2,160 horas</p>
                                <p><strong>Complejidad:</strong> Alta - Sistema empresarial completo</p>
                            </div>
                            <p class="mt-4">Este documento presenta una estimación detallada del costo de desarrollo de este proyecto desde cero, basado en el trabajo real realizado durante 24 meses.</p>
                        `
                    },
                    {
                        title: 'Métricas del Proyecto',
                        category: 'Estadísticas',
                        content: `
                            <h3>📈 Código y Archivos</h3>
                            <ul>
                                <li><strong>Total de archivos:</strong> 331 archivos</li>
                                <li><strong>Líneas de código:</strong> 53,673+ líneas</li>
                                <li><strong>Tamaño del código:</strong> ~76 MB</li>
                                <li><strong>Modelos Eloquent:</strong> 19 modelos</li>
                                <li><strong>Controladores:</strong> 34 controladores</li>
                                <li><strong>Migraciones:</strong> 30+ migraciones</li>
                                <li><strong>Seeders:</strong> 15+ seeders</li>
                                <li><strong>Vistas Blade:</strong> 80+ vistas</li>
                                <li><strong>Componentes:</strong> 25+ componentes reutilizables</li>
                            </ul>
                            <h3 class="mt-4">✨ Funcionalidades Principales</h3>
                            <ul>
                                <li>✅ Sistema de autenticación completo (Laravel Breeze)</li>
                                <li>✅ Cotizador de importaciones con cálculos complejos</li>
                                <li>✅ Panel de administración (9 módulos principales)</li>
                                <li>✅ Sistema de temas dinámico</li>
                                <li>✅ Gestión de contenido dinámico</li>
                                <li>✅ Guía interactiva del dashboard</li>
                                <li>✅ Sistema de tracking de paquetes</li>
                                <li>✅ Diseño glassmorphism personalizado</li>
                                <li>✅ Componentes UI reutilizables</li>
                                <li>✅ Sistema de roles y permisos</li>
                            </ul>
                        `
                    },
                    {
                        title: 'Mercado Internacional',
                        category: 'Costos USD',
                        content: `
                            <h3>🌎 Mercado Internacional (USD)</h3>
                            <table>
                                <thead>
                                    <tr>
                                        <th>Opción</th>
                                        <th>Tarifa Horaria</th>
                                        <th>Horas</th>
                                        <th>Costo Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><strong>Desarrollador Senior</strong></td>
                                        <td>$50 - $100 USD/hora</td>
                                        <td>1,800 horas</td>
                                        <td><strong>$90,000 - $180,000 USD</strong></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Desarrollador Mid-Level</strong></td>
                                        <td>$30 - $60 USD/hora</td>
                                        <td>1,800 horas</td>
                                        <td><strong>$54,000 - $108,000 USD</strong></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Agencia de Desarrollo</strong></td>
                                        <td>$80 - $150 USD/hora</td>
                                        <td>1,800 horas</td>
                                        <td><strong>$144,000 - $270,000 USD</strong></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Desarrollador Junior</strong></td>
                                        <td>$15 - $35 USD/hora</td>
                                        <td>2,200 horas</td>
                                        <td><strong>$33,000 - $77,000 USD</strong></td>
                                    </tr>
                                </tbody>
                            </table>
                            <p class="mt-4"><strong>💡 Nota:</strong> Los desarrolladores junior requieren más horas debido a su menor experiencia, pero tienen tarifas más bajas.</p>
                        `
                    },
                    {
                        title: 'Mercado Ecuatoriano',
                        category: 'Costos USD',
                        content: `
                            <h3>🇪🇨 Mercado Ecuatoriano (USD)</h3>
                            <table>
                                <thead>
                                    <tr>
                                        <th>Opción</th>
                                        <th>Tarifa Horaria</th>
                                        <th>Horas</th>
                                        <th>Costo Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><strong>Desarrollador Senior</strong></td>
                                        <td>$25 - $50 USD/hora</td>
                                        <td>1,800 horas</td>
                                        <td><strong>$45,000 - $90,000 USD</strong></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Desarrollador Mid-Level</strong></td>
                                        <td>$15 - $30 USD/hora</td>
                                        <td>1,800 horas</td>
                                        <td><strong>$27,000 - $54,000 USD</strong></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Agencia Local</strong></td>
                                        <td>$40 - $70 USD/hora</td>
                                        <td>1,800 horas</td>
                                        <td><strong>$72,000 - $126,000 USD</strong></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Desarrollador Junior</strong></td>
                                        <td>$8 - $18 USD/hora</td>
                                        <td>2,200 horas</td>
                                        <td><strong>$17,600 - $39,600 USD</strong></td>
                                    </tr>
                                </tbody>
                            </table>
                            <p class="mt-4"><strong>📊 Análisis:</strong> El mercado ecuatoriano ofrece tarifas más competitivas manteniendo calidad profesional.</p>
                        `
                    },
                    {
                        title: 'Mercado Latinoamericano',
                        category: 'Costos USD',
                        content: `
                            <h3>🌍 Mercado Latinoamericano (USD)</h3>
                            <table>
                                <thead>
                                    <tr>
                                        <th>Opción</th>
                                        <th>Tarifa Horaria</th>
                                        <th>Horas</th>
                                        <th>Costo Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><strong>Desarrollador Senior</strong></td>
                                        <td>$20 - $45 USD/hora</td>
                                        <td>1,800 horas</td>
                                        <td><strong>$36,000 - $81,000 USD</strong></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Desarrollador Mid-Level</strong></td>
                                        <td>$12 - $25 USD/hora</td>
                                        <td>1,800 horas</td>
                                        <td><strong>$21,600 - $45,000 USD</strong></td>
                                    </tr>
                                </tbody>
                            </table>
                            <p class="mt-4"><strong>💼 Ventaja:</strong> Excelente relación calidad-precio en el mercado latinoamericano.</p>
                        `
                    },
                    {
                        title: 'Desglose por Funcionalidad',
                        category: 'Análisis Detallado',
                        content: `
                            <h3>📋 Desglose por Funcionalidad</h3>
                            <table>
                                <thead>
                                    <tr>
                                        <th>Funcionalidad</th>
                                        <th>Horas</th>
                                        <th>Costo (Senior)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><strong>1. Sistema de Autenticación</strong></td>
                                        <td>40-60 horas</td>
                                        <td>$2,000 - $6,000 USD</td>
                                    </tr>
                                    <tr>
                                        <td><strong>2. Cotizador de Importaciones</strong></td>
                                        <td>200-300 horas</td>
                                        <td>$10,000 - $30,000 USD</td>
                                    </tr>
                                    <tr>
                                        <td><strong>3. Panel de Administración</strong></td>
                                        <td>400-600 horas</td>
                                        <td>$20,000 - $60,000 USD</td>
                                    </tr>
                                    <tr>
                                        <td><strong>4. Sistema de Temas</strong></td>
                                        <td>80-120 horas</td>
                                        <td>$4,000 - $12,000 USD</td>
                                    </tr>
                                    <tr>
                                        <td><strong>5. Gestión de Contenido</strong></td>
                                        <td>200-300 horas</td>
                                        <td>$10,000 - $30,000 USD</td>
                                    </tr>
                                    <tr>
                                        <td><strong>6. Diseño y UI/UX</strong></td>
                                        <td>300-400 horas</td>
                                        <td>$15,000 - $40,000 USD</td>
                                    </tr>
                                    <tr>
                                        <td><strong>7. Guía Interactiva</strong></td>
                                        <td>60-80 horas</td>
                                        <td>$3,000 - $8,000 USD</td>
                                    </tr>
                                    <tr>
                                        <td><strong>8. Sistema de Tracking</strong></td>
                                        <td>80-120 horas</td>
                                        <td>$4,000 - $12,000 USD</td>
                                    </tr>
                                    <tr>
                                        <td><strong>9. Testing y Debugging</strong></td>
                                        <td>200-300 horas</td>
                                        <td>$10,000 - $30,000 USD</td>
                                    </tr>
                                    <tr>
                                        <td><strong>10. Documentación y Despliegue</strong></td>
                                        <td>100-150 horas</td>
                                        <td>$5,000 - $15,000 USD</td>
                                    </tr>
                                </tbody>
                            </table>
                            <p class="mt-4"><strong>📊 Total estimado:</strong> 1,660 - 2,530 horas</p>
                        `
                    },
                    {
                        title: 'Tipos de Contrato',
                        category: 'Opciones de Pago',
                        content: `
                            <h3>🎯 Estimación por Tipo de Contrato</h3>
                            <div class="space-y-4">
                                <div class="bg-white/10 rounded-lg p-4">
                                    <h4 class="font-semibold text-lg mb-2">Contrato por Proyecto (Fixed Price)</h4>
                                    <p><strong>Rango estimado:</strong> $60,000 - $150,000 USD</p>
                                    <p class="mt-2"><strong>Ventajas:</strong> Precio fijo, sin sorpresas</p>
                                    <p><strong>Desventajas:</strong> Puede ser más caro si hay cambios</p>
                                </div>
                                <div class="bg-white/10 rounded-lg p-4">
                                    <h4 class="font-semibold text-lg mb-2">Contrato por Hora (Time & Materials)</h4>
                                    <p><strong>Rango estimado:</strong> $45,000 - $180,000 USD</p>
                                    <p class="mt-2"><strong>Ventajas:</strong> Flexibilidad, pagas solo lo usado</p>
                                    <p><strong>Desventajas:</strong> Costo variable según tiempo real</p>
                                </div>
                                <div class="bg-white/10 rounded-lg p-4">
                                    <h4 class="font-semibold text-lg mb-2">Contrato Mensual (Dedicado)</h4>
                                    <p><strong>Tarifa mensual:</strong> $3,000 - $8,000 USD/mes</p>
                                    <p><strong>Duración:</strong> 18-24 meses</p>
                                    <p><strong>Total:</strong> $54,000 - $192,000 USD</p>
                                </div>
                            </div>
                        `
                    },
                    {
                        title: 'Factores que Afectan el Costo',
                        category: 'Consideraciones',
                        content: `
                            <h3>⚠️ Factores que Aumentan el Costo:</h3>
                            <ul>
                                <li>✅ Cambios de requisitos durante el desarrollo</li>
                                <li>✅ Integraciones con APIs externas</li>
                                <li>✅ Requisitos de seguridad avanzados</li>
                                <li>✅ Optimización de rendimiento</li>
                                <li>✅ Soporte y mantenimiento post-lanzamiento</li>
                                <li>✅ Testing exhaustivo y QA</li>
                                <li>✅ Diseño UI/UX personalizado avanzado</li>
                            </ul>
                            <h3 class="mt-4">✅ Factores que Reducen el Costo:</h3>
                            <ul>
                                <li>✅ Uso de librerías y frameworks existentes (Laravel, Tailwind)</li>
                                <li>✅ Componentes reutilizables</li>
                                <li>✅ Plantillas base</li>
                                <li>✅ Desarrollo en equipo (especialización)</li>
                                <li>✅ Requisitos claros desde el inicio</li>
                            </ul>
                        `
                    },
                    {
                        title: 'Comparación con Proyectos Similares',
                        category: 'Benchmarking',
                        content: `
                            <h3>📊 Comparación con Proyectos Similares</h3>
                            <div class="space-y-4">
                                <div class="bg-white/10 rounded-lg p-4">
                                    <h4 class="font-semibold text-lg mb-2">E-commerce Básico</h4>
                                    <p><strong>Costo típico:</strong> $20,000 - $50,000 USD</p>
                                    <p><strong>Complejidad:</strong> Media</p>
                                    <p class="mt-2"><strong>Este proyecto:</strong> Más complejo (cálculos de impuestos, múltiples módulos)</p>
                                </div>
                                <div class="bg-white/10 rounded-lg p-4">
                                    <h4 class="font-semibold text-lg mb-2">ERP/CRM</h4>
                                    <p><strong>Costo típico:</strong> $100,000 - $500,000 USD</p>
                                    <p><strong>Complejidad:</strong> Muy Alta</p>
                                    <p class="mt-2"><strong>Este proyecto:</strong> Similar en complejidad pero más enfocado</p>
                                </div>
                                <div class="bg-white/10 rounded-lg p-4">
                                    <h4 class="font-semibold text-lg mb-2">Calculadoras Financieras</h4>
                                    <p><strong>Costo típico:</strong> $30,000 - $80,000 USD</p>
                                    <p><strong>Complejidad:</strong> Media-Alta</p>
                                    <p class="mt-2"><strong>Este proyecto:</strong> Similar pero con más funcionalidades administrativas</p>
                                </div>
                            </div>
                        `
                    },
                    {
                        title: 'Recomendaciones',
                        category: 'Guía de Contratación',
                        content: `
                            <h3>💡 Recomendaciones para el Cliente:</h3>
                            <ul>
                                <li><strong>Presupuesto recomendado:</strong> $60,000 - $120,000 USD</li>
                                <li><strong>Tiempo estimado:</strong> 18-24 meses (desarrollo part-time)</li>
                                <li><strong>Equipo recomendado:</strong> 1 desarrollador senior + 1 diseñador UI/UX (part-time)</li>
                            </ul>
                            <h3 class="mt-4">💼 Recomendaciones para el Desarrollador:</h3>
                            <ul>
                                <li><strong>Tarifa justa:</strong> $30 - $50 USD/hora (mercado latinoamericano)</li>
                                <li><strong>Contrato:</strong> Por proyecto con hitos de pago</li>
                                <li><strong>Documentación:</strong> Incluir en el costo base</li>
                            </ul>
                        `
                    },
                    {
                        title: 'Valor Agregado',
                        category: 'Beneficios Adicionales',
                        content: `
                            <h3>📝 Consideraciones Importantes:</h3>
                            <ul>
                                <li>✅ Este proyecto fue desarrollado en <strong>24 meses trabajando 2-3 horas por noche</strong></li>
                                <li>✅ Incluye <strong>documentación completa</strong> y <strong>guías de despliegue</strong></li>
                                <li>✅ Sistema <strong>100% funcional</strong> y <strong>probado en producción</strong></li>
                                <li>✅ Código <strong>bien estructurado</strong> y <strong>modular</strong></li>
                                <li>✅ Diseño <strong>moderno</strong> y <strong>responsive</strong></li>
                            </ul>
                            <h3 class="mt-4">🎨 Valor Agregado:</h3>
                            <ul>
                                <li>🎨 Diseño glassmorphism único y moderno</li>
                                <li>📱 Mobile-first completamente responsive</li>
                                <li>🔒 Sistema de seguridad robusto</li>
                                <li>📊 Panel de administración completo</li>
                                <li>🎯 Guía interactiva para usuarios</li>
                                <li>📚 Documentación exhaustiva</li>
                            </ul>
                        `
                    },
                    {
                        title: 'Conclusión',
                        category: 'Resumen Final',
                        content: `
                            <div class="bg-gradient-to-r from-green-500/20 to-blue-500/20 rounded-lg p-6 border border-white/20">
                                <h3 class="text-2xl font-bold mb-4">🎯 Conclusión</h3>
                                <p class="text-xl mb-4"><strong>Costo estimado realista: $60,000 - $120,000 USD</strong></p>
                                <p class="mb-4">Este rango considera:</p>
                                <ul class="mb-4">
                                    <li>✅ Desarrollo completo desde cero</li>
                                    <li>✅ Testing y debugging</li>
                                    <li>✅ Documentación</li>
                                    <li>✅ Diseño UI/UX personalizado</li>
                                    <li>✅ Despliegue y configuración inicial</li>
                                    <li>✅ Mercado latinoamericano/ecuatoriano</li>
                                </ul>
                                <p class="text-lg"><strong>⏱️ Tiempo estimado:</strong> 18-24 meses (desarrollo part-time) o 6-9 meses (desarrollo full-time)</p>
                            </div>
                            <p class="mt-4 text-center text-white/70">
                                <em>Última actualización: 6 de Diciembre 2025</em><br>
                                <em>Basado en el proyecto real desarrollado por Lenin Ramiro Nunez Valverde</em>
                            </p>
                        `
                    }
                ],
                
                init() {
                    // Inicialización
                },
                
                startPresentation() {
                    this.presentationActive = true;
                    this.currentStep = 0;
                    this.autoPlay();
                    this.scrollToTop();
                },
                
                pausePresentation() {
                    this.presentationActive = false;
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
                            this.pausePresentation();
                        }
                    }, 12000); // Cambia cada 12 segundos
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
                    if (!this.presentationActive || this.currentStep === index) {
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

