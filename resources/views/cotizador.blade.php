@php
    // Los productos y métodos de envío ya vienen del controlador
    // Convertir productos a formato compatible con el frontend
    $productsArray = [];
    foreach ($products as $product) {
        $productsArray[$product->key] = [
            'name' => $product->name,
            'adValorem' => (float) $product->ad_valorem,
            'arancelEspecifico' => (float) $product->arancel_especifico,
        ];
    }
@endphp

<x-app-layout>
    <x-slot name="styles">
        <style>
        /* Animación CTA botón "Comprar en la Tienda" - pulso de escala cada 2 segundos */
        .store-button-cta {
            position: relative !important;
            overflow: hidden !important;
            animation: store-btn-pulse 2s ease-in-out infinite !important;
            transition: transform 0.2s ease, box-shadow 0.2s ease !important;
        }
        .store-button-cta:hover {
            animation: none !important;
            transform: scale(1.08) !important;
            box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.4) !important;
        }
        @keyframes store-btn-pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.08); }
        }
        </style>
    </x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl leading-tight" style="color: {{ $cotizadorSection && $cotizadorSection->is_active && $cotizadorSection->title_color ? $cotizadorSection->title_color : '#ffffff' }};">
            {{ $cotizadorSection && $cotizadorSection->is_active ? $cotizadorSection->title : __('Cotizador de Importaciones') }}
        </h2>
    </x-slot>

    <x-ui.container>
        @if($cotizadorSection && $cotizadorSection->is_active && $cotizadorSection->description)
            <div class="mb-6 sm:mb-8">
                <p class="text-sm sm:text-base text-white text-opacity-80 mb-6">
                    {{ $cotizadorSection->description }}
                </p>
            </div>
        @else
            <div class="mb-6 sm:mb-8">
                <p class="text-sm sm:text-base text-white text-opacity-80 mb-6">
                    Completa el formulario para obtener una cotización personalizada de tus importaciones.
                </p>
            </div>
        @endif

        <div 
            x-data="cotizadorData()"
            x-init="init()"
            class="space-y-6"
            role="region"
            aria-label="Cotizador de importaciones"
        >
            {{-- Barra de progreso visual --}}
            <div class="mb-6" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="3" aria-label="Progreso del formulario">
                <div class="flex items-center justify-between gap-2 text-sm">
                    <div class="flex items-center gap-2" :class="formData.product ? 'text-green-300' : 'text-white/60'">
                        <span class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold transition-colors" :class="formData.product ? 'bg-green-500/30' : 'bg-white/10'">1</span>
                        <span>Producto</span>
                    </div>
                    <div class="flex-1 h-0.5 bg-white/20" :class="formData.product ? 'bg-green-500/30' : ''"></div>
                    <div class="flex items-center gap-2" :class="formData.quantity && formData.weight && formData.unitValue ? 'text-green-300' : 'text-white/60'">
                        <span class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold transition-colors" :class="formData.quantity && formData.weight && formData.unitValue ? 'bg-green-500/30' : 'bg-white/10'">2</span>
                        <span>Cantidades</span>
                    </div>
                    <div class="flex-1 h-0.5 bg-white/20" :class="formData.shippingMethod ? 'bg-green-500/30' : ''"></div>
                    <div class="flex items-center gap-2" :class="formData.shippingMethod ? 'text-green-300' : 'text-white/60'">
                        <span class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold transition-colors" :class="formData.shippingMethod ? 'bg-green-500/30' : 'bg-white/10'">3</span>
                        <span>Envío</span>
                    </div>
                </div>
            </div>

            <x-ui.card glassmorphism="true" padding="lg" class="cotizador-form-card">
                <form @submit.prevent="calculate()" class="space-y-6" aria-label="Formulario de cotización">
                    {{-- Información del Producto --}}
                    <div>
                        <h3 class="text-lg font-semibold mb-4" style="color: {{ $cotizadorSection && $cotizadorSection->is_active && $cotizadorSection->section_title_color ? $cotizadorSection->section_title_color : '#ffffff' }};">Información del Producto</h3>
                        
                        @php
                            $productLabelColor = $cotizadorSection && $cotizadorSection->is_active && $cotizadorSection->product_label_color ? $cotizadorSection->product_label_color : '#ffffff';
                        @endphp
                        <x-ui.form-group name="product">
                            <x-slot name="labelSlot">
                                <x-input-label for="product" :value="__('Seleccionar Producto')" class="mb-2" style="color: {{ $productLabelColor }};" />
                            </x-slot>
                            <div class="relative" @click.outside="showProductDropdown = false" role="combobox" aria-expanded="showProductDropdown" aria-haspopup="listbox" aria-controls="product-listbox">
                                <input 
                                    type="text"
                                    x-model="searchProduct"
                                    @input="filterProducts()"
                                    @focus="showProductDropdown = true"
                                    @keydown.escape="showProductDropdown = false"
                                    @keydown.arrow-down.prevent="showProductDropdown = true"
                                    placeholder="Buscar producto..."
                                    class="auth-form-input w-full"
                                    autocomplete="off"
                                    aria-label="Buscar y seleccionar producto"
                                    aria-autocomplete="list"
                                />
                                <div 
                                    id="product-listbox"
                                    x-show="showProductDropdown && filteredProducts.length > 0"
                                    x-cloak
                                    role="listbox"
                                    aria-label="Lista de productos"
                                    class="absolute z-50 w-full mt-2 bg-white/95 backdrop-filter backdrop-blur-xl border-2 border-white/40 rounded-lg max-h-60 overflow-y-auto shadow-2xl product-dropdown"
                                    style="box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3), 0 0 0 1px rgba(255, 255, 255, 0.5);"
                                >
                                    <template x-for="(product, index) in filteredProducts" :key="product.key">
                                        <button
                                            type="button"
                                            role="option"
                                            :aria-selected="formData.product === product.key"
                                            @click="selectProduct(product)"
                                            @keydown.enter.prevent="selectProduct(product)"
                                            class="w-full text-left px-4 py-3 hover:bg-blue-500/20 text-gray-800 hover:text-blue-700 font-medium transition-all duration-200 border-b border-gray-200/50 last:border-b-0 product-dropdown-item focus:ring-2 focus:ring-blue-500 focus:outline-none"
                                            x-text="product.name"
                                        ></button>
                                    </template>
                                </div>
                            </div>
                            <input type="hidden" x-model="formData.product" />
                            <p x-show="selectedProductName" class="mt-2 text-sm text-white/80">
                                <span x-text="'Producto seleccionado: ' + selectedProductName"></span>
                                <span class="ml-2 text-xs text-white/60" x-text="'(Key: ' + formData.product + ')'"></span>
                            </p>
                            <p x-show="!selectedProductName && formData.product" class="mt-2 text-sm text-yellow-300">
                                ⚠ Producto seleccionado pero sin nombre. Key: <span x-text="formData.product"></span>
                            </p>
                            <p x-show="Object.keys(products).length === 0" class="mt-2 text-sm text-amber-300" x-cloak>
                                No hay productos disponibles. Por favor contacte al administrador para configurar el catálogo.
                            </p>
                        </x-ui.form-group>

                        <x-ui.grid :cols="1" :cols-sm="2" :cols-md="3" gap="default" class="mt-4">
                            @php
                                $quantityLabelColor = $cotizadorSection && $cotizadorSection->is_active && $cotizadorSection->quantity_label_color ? $cotizadorSection->quantity_label_color : '#ffffff';
                            @endphp
                            <x-ui.form-group name="quantity">
                                <x-slot name="labelSlot">
                                    <x-input-label for="quantity" :value="__('Cantidad')" class="mb-2" style="color: {{ $quantityLabelColor }};" />
                                </x-slot>
                                <input 
                                    type="number" 
                                    x-model.number="formData.quantity"
                                    placeholder="1"
                                    min="1"
                                    step="1"
                                    required
                                    class="auth-form-input"
                                    aria-label="Cantidad de unidades"
                                    aria-invalid="formData.quantity <= 0"
                                />
                            </x-ui.form-group>

                            @php
                                $weightLabelColor = $cotizadorSection && $cotizadorSection->is_active && $cotizadorSection->weight_label_color ? $cotizadorSection->weight_label_color : '#ffffff';
                            @endphp
                            <x-ui.form-group name="weight">
                                <x-slot name="labelSlot">
                                    <x-input-label for="weight" :value="__('Peso Unitario (lb)')" class="mb-2" style="color: {{ $weightLabelColor }};" />
                                </x-slot>
                                <input 
                                    type="number" 
                                    x-model.number="formData.weight"
                                    placeholder="0.00"
                                    step="0.01"
                                    min="0"
                                    required
                                    class="auth-form-input"
                                    aria-label="Peso unitario en libras"
                                    aria-invalid="formData.weight <= 0"
                                />
                            </x-ui.form-group>

                            @php
                                $unitValueLabelColor = $cotizadorSection && $cotizadorSection->is_active && $cotizadorSection->unit_value_label_color ? $cotizadorSection->unit_value_label_color : '#ffffff';
                            @endphp
                            <x-ui.form-group name="unitValue">
                                <x-slot name="labelSlot">
                                    <x-input-label for="unitValue" :value="__('Valor Unitario (USD)')" class="mb-2" style="color: {{ $unitValueLabelColor }};" />
                                </x-slot>
                                <input 
                                    type="number" 
                                    x-model.number="formData.unitValue"
                                    placeholder="0.00"
                                    step="0.01"
                                    min="0"
                                    required
                                    class="auth-form-input"
                                    aria-label="Valor unitario en dólares"
                                    aria-invalid="formData.unitValue <= 0"
                                />
                            </x-ui.form-group>
                        </x-ui.grid>
                    </div>

                    {{-- Método de Envío --}}
                    <div class="border-t border-white border-opacity-20 pt-6">
                        <h3 class="text-lg font-semibold mb-4" style="color: {{ $cotizadorSection && $cotizadorSection->is_active && $cotizadorSection->section_title_color ? $cotizadorSection->section_title_color : '#ffffff' }};">Método de Envío</h3>
                        
                        @php
                            $shippingMethodLabelColor = $cotizadorSection && $cotizadorSection->is_active && $cotizadorSection->shipping_method_label_color ? $cotizadorSection->shipping_method_label_color : '#ffffff';
                        @endphp
                        <x-ui.form-group name="shippingMethod">
                            <x-slot name="labelSlot">
                                <x-input-label for="shippingMethod" :value="__('Seleccionar Método de Envío')" class="mb-2" style="color: {{ $shippingMethodLabelColor }};" />
                            </x-slot>
                            <select 
                                x-model="formData.shippingMethod"
                                class="w-full auth-form-input shipping-method-select"
                                required
                                aria-label="Seleccionar método de envío"
                            >
                                <option value="" style="background-color: rgba(30, 30, 30, 0.95); color: rgba(255, 255, 255, 0.7);">Seleccione un método</option>
                                <template x-for="method in shippingMethods" :key="method">
                                    <option :value="method" style="background-color: rgba(30, 30, 30, 0.95); color: white;" x-text="methodLabels[method] || method.charAt(0).toUpperCase() + method.slice(1)"></option>
                                </template>
                                <option value="" disabled x-show="shippingMethods.length === 0" x-cloak>No hay métodos de envío configurados</option>
                            </select>
                        </x-ui.form-group>
                    </div>

                    {{-- Botones de Acción --}}
                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-end gap-3 sm:gap-4 pt-6 border-t border-white border-opacity-20">
                        <button 
                            type="button" 
                            @click="reset()"
                            class="glass-button glass-button-full"
                        >
                            Limpiar Formulario
                        </button>
                        <button 
                            type="submit"
                            :disabled="isCalculating"
                            class="glass-button glass-button-lg glass-button-full"
                            :class="{ 'opacity-50 cursor-not-allowed': isCalculating }"
                            aria-busy="isCalculating"
                            aria-live="polite"
                        >
                            <span x-show="!isCalculating">Calcular Cotización</span>
                            <span x-show="isCalculating" x-cloak>Calculando...</span>
                        </button>
                    </div>
                </form>
            </x-ui.card>

            {{-- Resultados --}}
            <div 
                x-show="showResult && result"
                x-cloak
                x-transition:enter="transition ease-out duration-500"
                x-transition:enter-start="opacity-0 transform translate-y-8 scale-95"
                x-transition:enter-end="opacity-100 transform translate-y-0 scale-100"
                class="mt-6 sm:mt-8 result-container"
                role="status"
                aria-live="polite"
                aria-label="Resultado de la cotización"
            >
                <template x-if="result">
                    <div class="quote-result-card" id="quoteResultCard">
                        {{-- Header con icono y título --}}
                        <div class="quote-header">
                            <div class="quote-header-icon">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <h2 class="quote-title">Cotización de Importación</h2>
                                <p class="quote-subtitle">Detalles de su cotización personalizada</p>
                            </div>
                        </div>

                        {{-- Información del Producto --}}
                        <div class="quote-section">
                            <h3 class="quote-section-title">
                                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                                Información del Producto
                            </h3>
                            <div class="quote-info-grid">
                                <div class="quote-info-item">
                                    <span class="quote-info-label">Producto</span>
                                    <span class="quote-info-value" x-text="result?.productName || result?.product || 'N/A'"></span>
                                </div>
                                <div class="quote-info-item">
                                    <span class="quote-info-label">Cantidad</span>
                                    <span class="quote-info-value" x-text="result?.quantity || 0"></span>
                                </div>
                                <div class="quote-info-item">
                                    <span class="quote-info-label">Peso Total</span>
                                    <span class="quote-info-value" x-text="(result?.weight || 0).toFixed(2) + ' lb'"></span>
                                </div>
                            </div>
                        </div>

                        {{-- Costos --}}
                        <div class="quote-section">
                            <h3 class="quote-section-title">
                                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Costos
                            </h3>
                            <div class="quote-costs-grid" role="list" aria-label="Desglose de costos">
                                <div class="quote-cost-item" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">
                                    <div class="quote-cost-label">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                        </svg>
                                        Valor del Producto
                                    </div>
                                    <div class="quote-cost-value" x-text="'$' + (result?.productCost || 0).toFixed(2)"></div>
                                </div>
                                <div class="quote-cost-item" x-transition:enter="transition ease-out duration-300 delay-75" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">
                                    <div class="quote-cost-label">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                                        </svg>
                                        Costo de Envío
                                    </div>
                                    <div class="quote-cost-value" x-text="'$' + ((result?.shippingCost || 0) - (result?.arancelFijoCourier4x4 || 0)).toFixed(2)"></div>
                                </div>
                                <div class="quote-cost-item" x-show="result?.arancelFijoCourier4x4 > 0" x-transition:enter="transition ease-out duration-300 delay-150" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">
                                    <div class="quote-cost-label">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        Arancel Fijo (Courier 4x4)
                                    </div>
                                    <div class="quote-cost-value" x-text="'$' + (result?.arancelFijoCourier4x4 || 0).toFixed(2)"></div>
                                </div>
                                <div class="quote-cost-item" x-transition:enter="transition ease-out duration-300 delay-100" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">
                                    <div class="quote-cost-label">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                        </svg>
                                        Seguro CIF
                                    </div>
                                    <div class="quote-cost-value" x-text="'$' + (result?.seguroCIF || 0).toFixed(2)"></div>
                                </div>
                            </div>
                        </div>

                        {{-- Desglose de Impuestos --}}
                        <div class="quote-section">
                            <h3 class="quote-section-title">
                                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                </svg>
                                Desglose de Impuestos
                            </h3>
                            <div class="quote-taxes-grid">
                                <div class="quote-tax-item">
                                    <div class="quote-tax-label">
                                        Ad-valorem
                                        <span class="quote-tax-percent" x-text="'(' + ((result?.adValorem || 0) * 100).toFixed(0) + '%)'"></span>
                                    </div>
                                    <div class="quote-tax-value" x-text="'$' + (result?.impuestoAdvalorem || 0).toFixed(2)"></div>
                                </div>
                                <div class="quote-tax-item">
                                    <div class="quote-tax-label">
                                        Fodinfa
                                        <span class="quote-tax-percent" x-text="'(' + ((result?.fodinfa || 0) * 100).toFixed(1) + '%)'"></span>
                                    </div>
                                    <div class="quote-tax-value" x-text="'$' + (result?.impuestoFodinfa || 0).toFixed(2)"></div>
                                </div>
                                <div class="quote-tax-item">
                                    <div class="quote-tax-label">
                                        IVA
                                        <span class="quote-tax-percent" x-text="'(' + ((result?.iva || 0) * 100).toFixed(0) + '%)'"></span>
                                    </div>
                                    <div class="quote-tax-value" x-text="'$' + (result?.impuestoIva || 0).toFixed(2)"></div>
                                </div>
                                <div class="quote-tax-item">
                                    <div class="quote-tax-label">Arancel Específico</div>
                                    <div class="quote-tax-value" x-text="'$' + (result?.arancelEspecifico || 0).toFixed(2)"></div>
                                </div>
                                <div class="quote-tax-total">
                                    <div class="quote-tax-total-label">Total Impuestos</div>
                                    <div class="quote-tax-total-value" x-text="'$' + (result?.totalImpuestos || 0).toFixed(2)"></div>
                                </div>
                            </div>
                        </div>

                        {{-- Total Final --}}
                        <div class="quote-total-section">
                            <div class="quote-total-content">
                                <div class="quote-total-label">
                                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Total de la Cotización
                                </div>
                                <div class="quote-total-amount" x-text="'$' + (result?.totalCotizacion || 0).toFixed(2)"></div>
                            </div>
                        </div>

                        {{-- Smart product link (Fase 10) - Configurable desde dashboard - Animado para llamar atención --}}
                        @if(!$cotizadorSection || $cotizadorSection->store_button_visible)
                        <div class="quote-section border-t border-white/20 pt-4 mt-4">
                            <a 
                                :href="storeSearchUrl()"
                                target="_blank"
                                rel="noopener noreferrer"
                                @click="typeof window.trackStoreRedirect === 'function' && window.trackStoreRedirect(storeSearchUrl(), { product: formData.product, productName: result?.productName, total: result?.totalCotizacion })"
                                class="{{ ($cotizadorSection?->store_button_animated !== false) ? 'store-button-cta ' : '' }}inline-flex items-center gap-2 px-5 py-3.5 rounded-xl font-bold text-base"
                                style="background: {{ $cotizadorSection?->store_button_bg_color ?? 'rgba(34, 197, 94, 0.2)' }}; border: 2px solid {{ $cotizadorSection?->store_button_border_color ?? 'rgba(34, 197, 94, 0.4)' }}; color: {{ $cotizadorSection?->store_button_text_color ?? '#86efac' }};"
                            >
                                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                                {{ $cotizadorSection?->store_button_text ?? 'Comprar este producto en la tienda' }}
                            </a>
                        </div>
                        @endif

                        {{-- Botones de acción --}}
                        <div class="quote-actions" style="display: flex; flex-wrap: wrap; gap: 0.75rem;">
                            <button 
                                @click="downloadPDF()"
                                class="quote-download-button"
                                :disabled="isGeneratingPDF"
                            >
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <span x-show="!isGeneratingPDF">Descargar PDF</span>
                                <span x-show="isGeneratingPDF" x-cloak>Generando...</span>
                            </button>
                            <button 
                                @click="shareQuote()"
                                :disabled="isSharing"
                                class="quote-download-button"
                                style="background: rgba(59, 130, 246, 0.2); border-color: rgba(59, 130, 246, 0.4);"
                            >
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path>
                                </svg>
                                <span x-show="!isSharing">Compartir cotización</span>
                                <span x-show="isSharing" x-cloak>Compartiendo...</span>
                            </button>
                        </div>
                    </div>
                </template>
            </div>

            {{-- Información Adicional --}}
            <div class="mt-6 sm:mt-8">
                <x-ui.card glassmorphism="true" padding="default" class="info-card">
                    <div class="flex items-start">
                        <svg class="w-6 h-6 text-white mt-1 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <h4 class="font-semibold text-white mb-2">¿Necesitas ayuda?</h4>
                            <p class="text-sm text-white text-opacity-80">
                                Los cálculos incluyen impuestos, envío y seguro. Los resultados son estimaciones basadas en la información proporcionada.
                            </p>
                            <a 
                                href="{{ config('seo.store_url') }}" 
                                target="_blank"
                                rel="noopener noreferrer"
                                @click="typeof window.trackStoreRedirect === 'function' && window.trackStoreRedirect('{{ config('seo.store_url') }}')"
                                class="inline-block mt-3 text-sm font-medium text-white hover:text-opacity-80 auth-form-link"
                            >
                                Visitar Tienda →
                            </a>
                        </div>
                    </div>
                </x-ui.card>
            </div>

            {{-- Modal de Alerta/Validación --}}
            <template x-if="showAlert">
                <div 
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    @click.away="showAlert = false"
                    @keydown.escape.window="showAlert = false"
                    class="fixed inset-0 z-[9999] flex items-center justify-center p-4 alert-modal-overlay"
                    style="position: fixed !important; z-index: 9999 !important;"
                >
                    <div 
                        @click.stop
                        class="alert-modal-container"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 transform scale-95 translate-y-4"
                        x-transition:enter-end="opacity-100 transform scale-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100 transform scale-100 translate-y-0"
                        x-transition:leave-end="opacity-0 transform scale-95 translate-y-4"
                    >
                        <div class="alert-modal-content">
                            {{-- Icono de alerta --}}
                            <div class="alert-modal-icon">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                            </div>
                            
                            {{-- Título --}}
                            <h3 class="alert-modal-title">Validación</h3>
                            
                            {{-- Mensaje --}}
                            <p class="alert-modal-message" x-html="alertMessage ? alertMessage.replace(/\n/g, '<br>') : 'Error desconocido'"></p>
                            
                            {{-- Botón de cierre --}}
                            <div class="alert-modal-actions">
                                <button 
                                    @click="showAlert = false" 
                                    class="alert-modal-button"
                                    autofocus
                                >
                                    Aceptar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </template>

            {{-- Modal de Sugerencia Courier 4x4 --}}
            <template x-if="showCourierSuggestion">
                <div 
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    @click.away="showCourierSuggestion = false"
                    @keydown.escape.window="showCourierSuggestion = false"
                    class="fixed inset-0 z-[9999] flex items-center justify-center p-4 alert-modal-overlay"
                    style="position: fixed !important; z-index: 9999 !important;"
                >
                    <div 
                        @click.stop
                        class="alert-modal-container"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 transform scale-95 translate-y-4"
                        x-transition:enter-end="opacity-100 transform scale-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100 transform scale-100 translate-y-0"
                        x-transition:leave-end="opacity-0 transform scale-95 translate-y-4"
                    >
                        <div class="alert-modal-content">
                            {{-- Icono de sugerencia --}}
                            <div class="alert-modal-icon" style="background: rgba(34, 197, 94, 0.2); border-color: rgba(34, 197, 94, 0.4);">
                                <svg class="w-12 h-12 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            
                            {{-- Título --}}
                            <h3 class="alert-modal-title text-green-300">¡Sugerencia de Envío!</h3>
                            
                            {{-- Mensaje --}}
                            <div class="alert-modal-message">
                                <p class="mb-3">
                                    Tu producto <strong>califica para el método Courier 4x4</strong>, que puede ser más económico y rápido.
                                </p>
                                <div class="bg-white/5 rounded-lg p-3 mb-3 border border-white/10">
                                    <p class="text-sm text-white/80 mb-1"><strong>Detalles de tu envío:</strong></p>
                                    <p class="text-sm text-white/70">• Peso total: <span x-text="courierSuggestionData?.totalWeight"></span> libras (≤ 8.82 libras ✓)</p>
                                    <p class="text-sm text-white/70">• Valor FOB: $<span x-text="courierSuggestionData?.totalValueFob"></span> (≤ $400 ✓)</p>
                                </div>
                                <p class="text-sm text-white/80">
                                    <strong>Ventajas de Courier 4x4:</strong>
                                </p>
                                <ul class="text-sm text-white/70 list-disc list-inside mt-2 space-y-1">
                                    <li>Sin impuestos adicionales (solo arancel fijo de $20)</li>
                                    <li>Proceso más rápido</li>
                                    <li>Generalmente más económico para productos pequeños</li>
                                </ul>
                            </div>
                            
                            {{-- Botones de acción --}}
                            <div class="alert-modal-actions" style="display: flex; gap: 0.75rem; flex-direction: column;">
                                <button 
                                    @click="switchToCourier4x4()" 
                                    class="alert-modal-button"
                                    style="background: linear-gradient(135deg, rgba(34, 197, 94, 0.3), rgba(34, 197, 94, 0.2)); border-color: rgba(34, 197, 94, 0.4); color: #86efac;"
                                    autofocus
                                >
                                    ✓ Usar Courier 4x4 (Recomendado)
                                </button>
                                <button 
                                    @click="continueWithAereo()" 
                                    class="alert-modal-button"
                                    style="background: rgba(255, 255, 255, 0.1); border-color: rgba(255, 255, 255, 0.2);"
                                >
                                    Continuar con Aéreo
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </x-ui.container>

    <script>
        function cotizadorData() {
            const storeBase = '{{ ($cotizadorSection && $cotizadorSection->store_button_url_base) ? rtrim($cotizadorSection->store_button_url_base, "/") : rtrim(config("seo.store_url"), "/") }}'.replace(/\/$/, '');
            const storeSearchPath = '{{ ($cotizadorSection && $cotizadorSection->store_button_url_path) ? $cotizadorSection->store_button_url_path : config("seo.store_search_path", "/search") }}';
            return {
                products: @json($productsArray),
                shippingMethods: @json($shippingMethods),
                storeBase,
                storeSearchPath,
                shippingMethodRanges: @json($shippingMethodRanges ?? []),
                methodLabels: {
                    maritimo: 'Marítimo',
                    aereo: 'Aéreo',
                    aereoExpres: 'Aéreo Express',
                    courier4x4: 'Courier 4x4 (Arancel fijo $20)'
                },
                formData: {
                    product: '',
                    quantity: 1,
                    weight: 0,
                    unitValue: 0,
                    shippingMethod: ''
                },
                searchProduct: '',
                showProductDropdown: false,
                filteredProducts: [],
                selectedProductName: '',
                showResult: false,
                result: null,
                showAlert: false,
                alertMessage: '',
                showCourierSuggestion: false,
                courierSuggestionData: null,
                isCalculating: false,
                isGeneratingPDF: false,
                isSharing: false,

                storeSearchUrl() {
                    const q = (this.result?.productName || this.formData?.product || 'producto').toString();
                    return this.storeBase + this.storeSearchPath + '?q=' + encodeURIComponent(q);
                },

                init() {
                    this.filteredProducts = this.getAllProducts();
                    // Si no hay datos del servidor, cargar desde API (cache vacío, BD recién migrada)
                    if (Object.keys(this.products).length === 0 || this.shippingMethods.length === 0) {
                        this.loadDataFromApi();
                    }
                },

                async loadDataFromApi() {
                    try {
                        const url = window.location.origin + '/api/cotizador/data';
                        const response = await fetch(url);
                        if (!response.ok) {
                            console.warn('API cotizador:', response.status, response.statusText);
                            return;
                        }
                        const json = await response.json();
                        if (json.success && json.data) {
                            if (Object.keys(json.data.products || {}).length > 0) {
                                this.products = json.data.products;
                                this.filteredProducts = this.getAllProducts();
                            }
                            if (Array.isArray(json.data.shippingMethods) && json.data.shippingMethods.length > 0) {
                                this.shippingMethods = json.data.shippingMethods;
                            }
                            if (json.data.shippingMethodRanges && typeof json.data.shippingMethodRanges === 'object') {
                                this.shippingMethodRanges = json.data.shippingMethodRanges;
                            }
                        }
                    } catch (e) {
                        console.warn('No se pudieron cargar productos/métodos desde API:', e);
                    }
                },

                getAllProducts() {
                    return Object.keys(this.products).map(key => {
                        // Usar el nombre del producto desde la base de datos si está disponible
                        const product = this.products[key];
                        const productName = product.name || this.formatProductName(key);
                        return {
                            key: key,
                            name: productName
                        };
                    });
                },

                filterProducts() {
                    const search = this.searchProduct.toLowerCase();
                    if (!search) {
                        this.filteredProducts = this.getAllProducts();
                        return;
                    }
                    this.filteredProducts = this.getAllProducts().filter(p => 
                        p.name.toLowerCase().includes(search) || p.key.toLowerCase().includes(search)
                    );
                },

                selectProduct(product) {
                    this.formData.product = product.key;
                    this.selectedProductName = product.name;
                    this.searchProduct = product.name;
                    this.showProductDropdown = false;
                },

                formatProductName(key) {
                    let string = key.toString();
                    string = string.replace(/([a-z])([0-9])/gi, "$1 $2");
                    string = string.replace(/([a-z])([A-Z])/g, "$1 $2");
                    string = string.replace(/([A-Z])([A-Z][a-z])/g, "$1 $2");
                    string = string.replaceAll("_", "/");
                    string = string.replaceAll("PTHO", "(");
                    string = string.replaceAll("PTHC", ")");
                    string = string.replaceAll("EXS", " ");
                    return string;
                },


                validate() {
                    // Validar producto
                    if (!this.formData.product || this.formData.product === '') {
                        this.showError('⚠️ Por favor seleccione un producto válido del listado.');
                        return false;
                    }
                    
                    // Validar método de envío
                    if (!this.formData.shippingMethod || this.formData.shippingMethod === '') {
                        this.showError('⚠️ Por favor seleccione un método de envío válido.');
                        return false;
                    }
                    
                    // Validar que el método seleccionado esté en la lista de métodos activos
                    if (!this.shippingMethods.includes(this.formData.shippingMethod)) {
                        this.showError('⚠️ El método de envío seleccionado no está disponible. Por favor seleccione otro método.');
                        return false;
                    }
                    
                    // Validar valores numéricos
                    const totalWeight = this.formData.weight * this.formData.quantity;
                    if (this.formData.quantity <= 0 || this.formData.weight <= 0 || this.formData.unitValue <= 0) {
                        this.showError('⚠️ Por favor ingrese valores válidos mayores a cero en cantidad, peso y valor unitario.');
                        return false;
                    }
                    
                    // Validar peso según las tarifas activas del método seleccionado
                    if (this.formData.shippingMethod && this.shippingMethodRanges[this.formData.shippingMethod]) {
                        const ranges = this.shippingMethodRanges[this.formData.shippingMethod];
                        const minWeight = ranges.min_weight;
                        const maxWeight = ranges.max_weight;
                        const hasUnlimited = ranges.has_unlimited;
                        
                        // Verificar si el peso está dentro de algún rango
                        let weightInRange = false;
                        for (const range of ranges.ranges) {
                            if (totalWeight >= range.min && (range.max === null || totalWeight <= range.max)) {
                                weightInRange = true;
                                break;
                            }
                        }
                        
                        if (!weightInRange) {
                            if (minWeight !== null && totalWeight < minWeight) {
                                this.showError(`⚠️ Para envío ${this.formData.shippingMethod}, el peso mínimo es de ${minWeight} libras.\n\nPeso actual: ${totalWeight.toFixed(2)} libras`);
                                return false;
                            } else if (maxWeight !== null && totalWeight > maxWeight && !hasUnlimited) {
                                this.showError(`⚠️ Para envío ${this.formData.shippingMethod}, el peso máximo es de ${maxWeight} libras.\n\nPeso actual: ${totalWeight.toFixed(2)} libras`);
                                return false;
                            } else {
                                // Construir mensaje con rangos disponibles
                                const rangesText = ranges.ranges.map(r => {
                                    if (r.max === null) {
                                        return `${r.min}+ libras`;
                                    }
                                    return `${r.min}-${r.max} libras`;
                                }).join(', ');
                                this.showError(`⚠️ No hay tarifa disponible para el peso ${totalWeight.toFixed(2)} libras con el método ${this.formData.shippingMethod}.\n\nRangos disponibles: ${rangesText}`);
                                return false;
                            }
                        }
                    }
                    
                    // Validar Courier 4x4 (validaciones específicas adicionales)
                    if (this.formData.shippingMethod === 'courier4x4') {
                        const totalValueFob = this.formData.unitValue * this.formData.quantity;
                        if (totalValueFob > 400) {
                            this.showError(`⚠️ Para envío Courier 4x4, el valor FOB máximo es de $400.\n\nValor FOB actual: $${totalValueFob.toFixed(2)}`);
                            return false;
                        }
                    }
                    
                    // Validar prendas de vestir (incluye keys como PrendasDeVestirYCalzado o PrendasDeVestir/ Zapatos/...)
                    const isPrendas = this.formData.product === 'PrendasDeVestirYCalzado' || 
                        (this.formData.product && this.formData.product.includes('PrendasDeVestir'));
                    if (isPrendas && totalWeight > 8) {
                        this.showError(`⚠️ No se puede realizar el envío de prendas de vestir y calzado si el peso excede las 8 libras.\n\nPeso actual: ${totalWeight.toFixed(2)} libras`);
                        return false;
                    }
                    
                    return true;
                },

                // Verificar si el producto califica para Courier 4x4
                qualifiesForCourier4x4() {
                    const totalWeight = this.formData.weight * this.formData.quantity;
                    const totalValueFob = this.formData.unitValue * this.formData.quantity;
                    const maxWeight = 8.82; // 4 kg en libras
                    const maxValueFob = 400; // Valor FOB máximo en USD
                    
                    return totalWeight <= maxWeight && totalValueFob <= maxValueFob;
                },

                async calculate() {
                    if (!this.validate()) {
                        return;
                    }

                    // Verificar si califica para Courier 4x4 cuando se selecciona Aéreo
                    if (this.formData.shippingMethod === 'aereo' && this.qualifiesForCourier4x4()) {
                        const totalWeight = this.formData.weight * this.formData.quantity;
                        const totalValueFob = this.formData.unitValue * this.formData.quantity;
                        
                        this.courierSuggestionData = {
                            totalWeight: totalWeight.toFixed(2),
                            totalValueFob: totalValueFob.toFixed(2)
                        };
                        this.showCourierSuggestion = true;
                        return; // Detener el cálculo hasta que el usuario decida
                    }

                    // Proceder con el cálculo normal
                    await this.performCalculation();
                },

                async performCalculation() {
                    // Mostrar indicador de carga
                    this.isCalculating = true;
                    this.showResult = false;

                    try {
                        // Obtener token CSRF
                        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                        
                        if (!csrfToken) {
                            this.showError('Error de seguridad. Por favor recargue la página.');
                            return;
                        }

                        const url = '{{ route("cotizador.calculate") }}';

                        // Enviar datos al backend
                        const response = await fetch(url, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': csrfToken
                            },
                            body: JSON.stringify(this.formData)
                        });

                        const data = await response.json();

                        if (!response.ok || !data.success) {
                            // Mostrar errores del backend
                            const errorMessage = data.message || data.errors?.[0] || 'Error al calcular la cotización';
                            this.showError(errorMessage);
                            return;
                        }

                        // Asignar resultado directamente desde data.data
                        if (data.data) {
                            this.result = data.data;
                            this.result.product = this.formData.product;
                            this.showResult = true;
                            if (typeof window.trackQuoteCalculated === 'function') {
                                window.trackQuoteCalculated({ ...this.result, product: this.formData.product });
                            }
                        } else {
                            this.showError('No se recibieron datos del servidor.');
                            return;
                        }
                        
                        // Scroll suave al resultado después de un pequeño delay
                        setTimeout(() => {
                            this.scrollToResult();
                        }, 100);

                    } catch (error) {
                        this.showError('Error de conexión. Por favor intente nuevamente.');
                    } finally {
                        this.isCalculating = false;
                    }
                },

                // Cambiar a Courier 4x4 y calcular
                switchToCourier4x4() {
                    this.formData.shippingMethod = 'courier4x4';
                    this.showCourierSuggestion = false;
                    this.performCalculation();
                },

                // Continuar con Aéreo
                continueWithAereo() {
                    this.showCourierSuggestion = false;
                    this.performCalculation();
                },

                scrollToResult() {
                    const resultElement = document.querySelector('.result-container');
                    if (resultElement) {
                        resultElement.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }
                },

                async shareQuote() {
                    if (!this.result) return;
                    this.isSharing = true;
                    try {
                        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                        const res = await fetch('{{ route("cotizador.share") }}', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                            body: JSON.stringify({
                                quoteData: {
                                    ...this.result,
                                    product: this.formData.product,
                                    productName: this.result.productName || this.result.product,
                                    quantity: this.formData.quantity,
                                    weight: this.result.weight,
                                    shippingMethod: this.formData.shippingMethod
                                }
                            })
                        });
                        const data = await res.json();
                        if (data.success && data.url) {
                            await navigator.clipboard.writeText(data.url);
                            this.showError('✓ Enlace copiado. Compártelo con quien quieras.');
                        } else {
                            this.showError('No se pudo generar el enlace.');
                        }
                    } catch (e) {
                        this.showError('Error al compartir.');
                    } finally {
                        this.isSharing = false;
                    }
                },

                // Función helper para generar PDF profesional
                generateProfessionalPDF(resultData, jsPDF) {
                    if (!resultData) {
                        throw new Error('No hay datos de resultado para generar el PDF');
                    }
                    
                    // Usar resultData directamente para evitar problemas de scope
                    const result = resultData;
                    const pdf = new jsPDF('p', 'mm', 'a4');
                    const pageWidth = 210;
                    const pageHeight = 297;
                    let yPosition = 20;
                    const margin = 15;
                    const lineHeight = 7;
                    const sectionSpacing = 10;
                    
                    // Función helper para agregar nueva página si es necesario
                    const checkPageBreak = (requiredSpace) => {
                        if (yPosition + requiredSpace > pageHeight - margin) {
                            pdf.addPage();
                            yPosition = margin;
                            return true;
                        }
                        return false;
                    };
                    
                    // Función helper para formatear moneda
                    const formatCurrency = (value) => {
                        return '$' + (parseFloat(value || 0)).toFixed(2);
                    };
                    
                    // Función helper para dibujar línea
                    const drawLine = () => {
                        pdf.setDrawColor(200, 200, 200);
                        pdf.line(margin, yPosition, pageWidth - margin, yPosition);
                        yPosition += 3;
                    };
                    
                    // Función helper para dibujar tabla
                    const drawTable = (headers, rows, colWidths, align = 'left') => {
                        const startY = yPosition;
                        const rowHeight = 8;
                        const headerHeight = 10;
                        
                        // Header con fondo gris
                        pdf.setFillColor(240, 240, 240);
                        pdf.setDrawColor(200, 200, 200);
                        pdf.rect(margin, yPosition, pageWidth - (margin * 2), headerHeight, 'FD');
                        
                        // Texto del header
                        pdf.setFontSize(10);
                        pdf.setTextColor(50, 50, 50);
                        pdf.setFont(undefined, 'bold');
                        let xPos = margin + 5;
                        headers.forEach((header, index) => {
                            pdf.text(header, xPos, yPosition + 7);
                            xPos += colWidths[index];
                        });
                        yPosition += headerHeight;
                        
                        // Filas de datos
                        pdf.setFont(undefined, 'normal');
                        pdf.setFontSize(9);
                        rows.forEach((row, rowIndex) => {
                            checkPageBreak(rowHeight);
                            
                            // Alternar color de fondo
                            if (rowIndex % 2 === 0) {
                                pdf.setFillColor(250, 250, 250);
                                pdf.rect(margin, yPosition, pageWidth - (margin * 2), rowHeight, 'F');
                            }
                            
                            xPos = margin + 5;
                            row.forEach((cell, cellIndex) => {
                                pdf.text(cell, xPos, yPosition + 6);
                                xPos += colWidths[cellIndex];
                            });
                            
                            // Línea separadora
                            pdf.setDrawColor(230, 230, 230);
                            pdf.line(margin, yPosition + rowHeight, pageWidth - margin, yPosition + rowHeight);
                            
                            yPosition += rowHeight;
                        });
                        
                        yPosition += sectionSpacing;
                    };
                    
                    // ENCABEZADO
                    pdf.setFillColor(99, 102, 241); // Color índigo
                    pdf.rect(0, 0, pageWidth, 50, 'F');
                    
                    pdf.setTextColor(255, 255, 255);
                    pdf.setFontSize(24);
                    pdf.setFont(undefined, 'bold');
                    pdf.text('FLAT RATE IMPORTS', margin, 18);
                    
                    pdf.setFontSize(16);
                    pdf.setFont(undefined, 'normal');
                    pdf.text('COTIZACIÓN DE IMPORTACIÓN', margin, 28);
                    
                    pdf.setFontSize(10);
                    const date = new Date().toLocaleDateString('es-ES', { 
                        year: 'numeric', 
                        month: 'long', 
                        day: 'numeric' 
                    });
                    pdf.text('Fecha: ' + date, margin, 38);
                    
                    yPosition = 60;
                    
                    // INFORMACIÓN DEL PRODUCTO
                    pdf.setTextColor(0, 0, 0);
                    pdf.setFontSize(14);
                    pdf.setFont(undefined, 'bold');
                    pdf.text('Información del Producto', margin, yPosition);
                    yPosition += lineHeight + 3;
                    
                    drawLine();
                    
                    const productInfo = [
                        ['Producto:', result.productName || result.product || 'N/A'],
                        ['Cantidad:', (result.quantity || 0).toString()],
                        ['Peso Total:', (parseFloat(result.weight || 0).toFixed(2) + ' lb')]
                    ];
                    
                    pdf.setFontSize(10);
                    pdf.setFont(undefined, 'normal');
                    productInfo.forEach(([label, value]) => {
                        checkPageBreak(lineHeight + 2);
                        pdf.setFont(undefined, 'bold');
                        pdf.text(label, margin, yPosition);
                        pdf.setFont(undefined, 'normal');
                        pdf.text(value, margin + 50, yPosition);
                        yPosition += lineHeight + 2;
                    });
                    
                    yPosition += sectionSpacing;
                    
                    // COSTOS
                    checkPageBreak(30);
                    pdf.setFontSize(14);
                    pdf.setFont(undefined, 'bold');
                    pdf.text('Costos', margin, yPosition);
                    yPosition += lineHeight + 3;
                    
                    drawLine();
                    
                    const shippingCost = (parseFloat(result.shippingCost || 0) - parseFloat(result.arancelFijoCourier4x4 || 0));
                    const costsData = [
                        ['Concepto', 'Monto'],
                        ['Valor del Producto', formatCurrency(result.productCost)],
                        ['Costo de Envío', formatCurrency(shippingCost)]
                    ];
                    
                    if (parseFloat(result.arancelFijoCourier4x4 || 0) > 0) {
                        costsData.push(['Arancel Fijo (Courier 4x4)', formatCurrency(result.arancelFijoCourier4x4)]);
                    }
                    
                    costsData.push(['Seguro CIF', formatCurrency(result.seguroCIF)]);
                    
                    drawTable(
                        costsData[0],
                        costsData.slice(1),
                        [120, 70],
                        'left'
                    );
                    
                    // IMPUESTOS
                    checkPageBreak(40);
                    pdf.setFontSize(14);
                    pdf.setFont(undefined, 'bold');
                    pdf.text('Desglose de Impuestos', margin, yPosition);
                    yPosition += lineHeight + 3;
                    
                    drawLine();
                    
                    const taxesData = [
                        ['Impuesto', 'Porcentaje', 'Monto']
                    ];
                    
                    if (parseFloat(result.impuestoAdvalorem || 0) > 0) {
                        taxesData.push([
                            'Ad-valorem',
                            ((result.adValorem || 0) * 100).toFixed(0) + '%',
                            formatCurrency(result.impuestoAdvalorem)
                        ]);
                    }
                    
                    if (parseFloat(result.impuestoFodinfa || 0) > 0) {
                        taxesData.push([
                            'Fodinfa',
                            ((result.fodinfa || 0) * 100).toFixed(1) + '%',
                            formatCurrency(result.impuestoFodinfa)
                        ]);
                    }
                    
                    if (parseFloat(result.impuestoIva || 0) > 0) {
                        taxesData.push([
                            'IVA',
                            ((result.iva || 0) * 100).toFixed(0) + '%',
                            formatCurrency(result.impuestoIva)
                        ]);
                    }
                    
                    if (parseFloat(result.arancelEspecifico || 0) > 0) {
                        taxesData.push([
                            'Arancel Específico',
                            '-',
                            formatCurrency(result.arancelEspecifico)
                        ]);
                    }
                    
                    taxesData.push([
                        'TOTAL IMPUESTOS',
                        '',
                        formatCurrency(result.totalImpuestos)
                    ]);
                    
                    drawTable(
                        taxesData[0],
                        taxesData.slice(1),
                        [80, 40, 50],
                        'left'
                    );
                    
                    // TOTAL FINAL
                    checkPageBreak(25);
                    yPosition += 5;
                    drawLine();
                    
                    pdf.setFillColor(99, 102, 241);
                    pdf.rect(margin, yPosition, pageWidth - (margin * 2), 20, 'F');
                    
                    pdf.setTextColor(255, 255, 255);
                    pdf.setFontSize(16);
                    pdf.setFont(undefined, 'bold');
                    pdf.text('TOTAL DE LA COTIZACIÓN', margin + 5, yPosition + 12);
                    
                    pdf.setFontSize(20);
                    pdf.text(formatCurrency(result.totalCotizacion), pageWidth - margin - 60, yPosition + 12);
                    
                    yPosition += 25;
                    
                    // PIE DE PÁGINA
                    checkPageBreak(15);
                    yPosition = pageHeight - 20;
                    drawLine();
                    
                    pdf.setTextColor(150, 150, 150);
                    pdf.setFontSize(8);
                    pdf.setFont(undefined, 'normal');
                    pdf.text('Flat Rate Imports - www.flatrateimports.com', margin, yPosition);
                    pdf.text('Este documento es una cotización estimada y puede variar según las condiciones finales de importación.', 
                            margin, yPosition + 5, { maxWidth: pageWidth - (margin * 2) });
                    
                    return pdf;
                },
                
                async downloadPDF() {
                    if (!this.result) {
                        this.showError('No hay resultados para generar el PDF.');
                        return;
                    }
                    
                    this.isGeneratingPDF = true;
                    
                    try {
                        // Verificar y cargar jsPDF
                        let jsPDF;
                        if (typeof window.jspdf !== 'undefined' && window.jspdf.jsPDF) {
                            jsPDF = window.jspdf.jsPDF;
                        } else {
                            // Cargar desde CDN como fallback
                            await this.loadScript('https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js');
                            if (typeof window.jspdf !== 'undefined' && window.jspdf.jsPDF) {
                                jsPDF = window.jspdf.jsPDF;
                            } else {
                                throw new Error('No se pudo cargar jsPDF desde CDN');
                            }
                        }
                        
                        if (typeof jsPDF !== 'function') {
                            throw new Error(`jsPDF no es una función. Tipo: ${typeof jsPDF}`);
                        }
                        
                        if (!this.result) {
                            throw new Error('No hay datos de resultado disponibles');
                        }
                        
                        const pdf = this.generateProfessionalPDF(this.result, jsPDF);
                        
                        // Guardar PDF
                        const result = this.result;
                        const fileName = `cotizacion_${(result.productName || result.product || 'producto').replace(/[^a-z0-9]/gi, '_')}_${new Date().toISOString().split('T')[0]}.pdf`;
                        pdf.save(fileName);
                        
                    } catch (error) {
                        const errorMessage = error.message || 'Error desconocido al generar PDF';
                        this.showError(`Error al generar PDF: ${errorMessage}`);
                        console.error('Error generando PDF:', error);
                    } finally {
                        this.isGeneratingPDF = false;
                    }
                },

                reset() {
                    this.formData = {
                        product: '',
                        quantity: 1,
                        weight: 0,
                        unitValue: 0,
                        shippingMethod: ''
                    };
                    this.searchProduct = '';
                    this.selectedProductName = '';
                    this.showResult = false;
                    this.result = null;
                },

                loadScript(src) {
                    return new Promise((resolve, reject) => {
                        // Verificar si el script ya está cargado
                        const existingScript = document.querySelector(`script[src="${src}"]`);
                        if (existingScript) {
                            resolve();
                            return;
                        }
                        
                        const script = document.createElement('script');
                        script.src = src;
                        script.async = true;
                        script.onload = () => {
                            resolve();
                        };
                        script.onerror = () => {
                            reject(new Error(`No se pudo cargar el script: ${src}`));
                        };
                        document.head.appendChild(script);
                    });
                },

                showError(message) {
                    // Asegurar que el mensaje no esté vacío
                    this.alertMessage = message || 'Ha ocurrido un error';
                    
                    // Forzar el cambio de showAlert
                    this.showAlert = true;
                }
            }
        }
    </script>
</x-app-layout>

@push('scripts')
    @vite(['resources/js/cotizador-alpine.js'])
@endpush
