<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-white leading-tight">
            {{ __('Editar Paquete') }}
        </h2>
    </x-slot>

    <x-ui.container>
        <x-ui.card glassmorphism="true" padding="lg" class="mb-6">
            <div class="mb-4 sm:mb-6">
                <a href="{{ route('admin.packages.index') }}" class="inline-flex items-center text-white/80 hover:text-white transition-colors mb-3 sm:mb-4 text-sm sm:text-base">
                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 mr-1.5 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Volver a Paquetes
                </a>
                <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-white mb-2">
                    Editar Paquete: {{ $package->tracking_number }}
                </h1>
                <p class="text-xs sm:text-sm md:text-base text-white/80">
                    Actualiza la información del paquete.
                </p>
            </div>

            <form method="POST" action="{{ route('admin.packages.update', $package->id) }}" class="space-y-6">
                @csrf
                @method('PATCH')

                {{-- Número de Tracking --}}
                <div>
                    <x-input-label for="tracking_number" :value="__('Número de Tracking *')" class="text-white/90 mb-2" />
                    <x-text-input 
                        id="tracking_number" 
                        name="tracking_number" 
                        type="text" 
                        class="auth-form-input" 
                        :value="old('tracking_number', $package->tracking_number)" 
                        required 
                        autofocus 
                        placeholder="Ej: TBA326257143026"
                    />
                    <x-input-error class="mt-2" :messages="$errors->get('tracking_number')" />
                </div>

                {{-- Usuario (Opcional) --}}
                <div>
                    <x-input-label for="user_id" :value="__('Usuario (Opcional)')" class="text-white/90 mb-2" />
                    <select 
                        id="user_id" 
                        name="user_id" 
                        class="auth-form-input"
                    >
                        <option value="">Sin asignar</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('user_id', $package->user_id) == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>
                    <x-input-error class="mt-2" :messages="$errors->get('user_id')" />
                </div>

                {{-- Transportista --}}
                <div>
                    <x-input-label for="carrier" :value="__('Transportista')" class="text-white/90 mb-2" />
                    <x-text-input 
                        id="carrier" 
                        name="carrier" 
                        type="text" 
                        class="auth-form-input" 
                        :value="old('carrier', $package->carrier)" 
                        placeholder="Ej: USPS, FedEx, UPS, DHL, Amazon"
                    />
                    <x-input-error class="mt-2" :messages="$errors->get('carrier')" />
                </div>

                {{-- Estado --}}
                <div>
                    <x-input-label for="status" :value="__('Estado *')" class="text-white/90 mb-2" />
                    <select 
                        id="status" 
                        name="status" 
                        class="auth-form-input"
                        required
                    >
                        <option value="pending" {{ old('status', $package->status) == 'pending' ? 'selected' : '' }}>Pendiente</option>
                        <option value="in_transit" {{ old('status', $package->status) == 'in_transit' ? 'selected' : '' }}>En Tránsito</option>
                        <option value="received" {{ old('status', $package->status) == 'received' ? 'selected' : '' }}>Recibido</option>
                        <option value="in_customs" {{ old('status', $package->status) == 'in_customs' ? 'selected' : '' }}>En Aduana</option>
                        <option value="delivered" {{ old('status', $package->status) == 'delivered' ? 'selected' : '' }}>Entregado</option>
                    </select>
                    <x-input-error class="mt-2" :messages="$errors->get('status')" />
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    {{-- Origen --}}
                    <div>
                        <x-input-label for="origin" :value="__('Origen')" class="text-white/90 mb-2" />
                        <x-text-input 
                            id="origin" 
                            name="origin" 
                            type="text" 
                            class="auth-form-input" 
                            :value="old('origin', $package->origin)" 
                            placeholder="Ej: New York, NY, USA"
                        />
                        <x-input-error class="mt-2" :messages="$errors->get('origin')" />
                    </div>

                    {{-- Destino --}}
                    <div>
                        <x-input-label for="destination" :value="__('Destino')" class="text-white/90 mb-2" />
                        <x-text-input 
                            id="destination" 
                            name="destination" 
                            type="text" 
                            class="auth-form-input" 
                            :value="old('destination', $package->destination)" 
                            placeholder="Ej: Miami, FL, USA"
                        />
                        <x-input-error class="mt-2" :messages="$errors->get('destination')" />
                    </div>
                </div>

                {{-- Descripción --}}
                <div>
                    <x-input-label for="description" :value="__('Descripción')" class="text-white/90 mb-2" />
                    <textarea 
                        id="description" 
                        name="description" 
                        rows="3"
                        class="auth-form-input"
                        placeholder="Ej: Paquete con productos electrónicos"
                    >{{ old('description', $package->description) }}</textarea>
                    <x-input-error class="mt-2" :messages="$errors->get('description')" />
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    {{-- Peso --}}
                    <div>
                        <x-input-label for="weight" :value="__('Peso (lbs)')" class="text-white/90 mb-2" />
                        <x-text-input 
                            id="weight" 
                            name="weight" 
                            type="number" 
                            step="0.01"
                            min="0"
                            class="auth-form-input" 
                            :value="old('weight', $package->weight)" 
                            placeholder="Ej: 5.50"
                        />
                        <x-input-error class="mt-2" :messages="$errors->get('weight')" />
                    </div>

                    {{-- Valor --}}
                    <div>
                        <x-input-label for="value" :value="__('Valor Declarado (USD)')" class="text-white/90 mb-2" />
                        <x-text-input 
                            id="value" 
                            name="value" 
                            type="number" 
                            step="0.01"
                            min="0"
                            class="auth-form-input" 
                            :value="old('value', $package->value)" 
                            placeholder="Ej: 250.00"
                        />
                        <x-input-error class="mt-2" :messages="$errors->get('value')" />
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                    {{-- Fecha de Envío --}}
                    <div>
                        <x-input-label for="shipped_date" :value="__('Fecha de Envío')" class="text-white/90 mb-2" />
                        <x-text-input 
                            id="shipped_date" 
                            name="shipped_date" 
                            type="date" 
                            class="auth-form-input" 
                            :value="old('shipped_date', $package->shipped_date ? $package->shipped_date->format('Y-m-d') : '')"
                        />
                        <x-input-error class="mt-2" :messages="$errors->get('shipped_date')" />
                    </div>

                    {{-- Entrega Estimada --}}
                    <div>
                        <x-input-label for="estimated_delivery" :value="__('Entrega Estimada')" class="text-white/90 mb-2" />
                        <x-text-input 
                            id="estimated_delivery" 
                            name="estimated_delivery" 
                            type="date" 
                            class="auth-form-input" 
                            :value="old('estimated_delivery', $package->estimated_delivery ? $package->estimated_delivery->format('Y-m-d') : '')"
                        />
                        <x-input-error class="mt-2" :messages="$errors->get('estimated_delivery')" />
                    </div>

                    {{-- Fecha de Entrega --}}
                    <div>
                        <x-input-label for="delivered_date" :value="__('Fecha de Entrega')" class="text-white/90 mb-2" />
                        <x-text-input 
                            id="delivered_date" 
                            name="delivered_date" 
                            type="date" 
                            class="auth-form-input" 
                            :value="old('delivered_date', $package->delivered_date ? $package->delivered_date->format('Y-m-d') : '')"
                        />
                        <x-input-error class="mt-2" :messages="$errors->get('delivered_date')" />
                    </div>
                </div>

                {{-- Notas --}}
                <div>
                    <x-input-label for="notes" :value="__('Notas')" class="text-white/90 mb-2" />
                    <textarea 
                        id="notes" 
                        name="notes" 
                        rows="3"
                        class="auth-form-input"
                        placeholder="Notas adicionales sobre el paquete"
                    >{{ old('notes', $package->notes) }}</textarea>
                    <x-input-error class="mt-2" :messages="$errors->get('notes')" />
                </div>

                {{-- Botones --}}
                <div class="flex flex-col sm:flex-row gap-4 pt-4">
                    <button type="submit" class="glass-button glass-button-lg flex-1 sm:flex-none">
                        Actualizar Paquete
                    </button>
                    <a href="{{ route('admin.packages.index') }}" class="glass-button glass-button-lg glass-button-secondary flex-1 sm:flex-none text-center">
                        Cancelar
                    </a>
                </div>
            </form>
        </x-ui.card>
    </x-ui.container>
</x-app-layout>






