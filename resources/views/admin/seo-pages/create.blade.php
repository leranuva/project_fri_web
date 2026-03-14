<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-white leading-tight">Nueva Página SEO</h2>
    </x-slot>

    <x-ui.container>
        <a href="{{ route('admin.seo-pages.index') }}" class="inline-flex text-white/80 hover:text-white mb-6">← Volver</a>

        <x-ui.card glassmorphism="true" padding="lg">
            <form method="POST" action="{{ route('admin.seo-pages.store') }}">
                @csrf
                <div class="space-y-4">
                    <x-ui.form-group name="keyword">
                        <x-slot name="labelSlot"><label class="text-white/90">Keyword</label></x-slot>
                        <input type="text" name="keyword" value="{{ old('keyword') }}" class="auth-form-input w-full" required>
                    </x-ui.form-group>
                    <x-ui.form-group name="slug">
                        <x-slot name="labelSlot"><label class="text-white/90">Slug (URL)</label></x-slot>
                        <input type="text" name="slug" value="{{ old('slug') }}" placeholder="importar-iphone-ecuador" class="auth-form-input w-full" required>
                    </x-ui.form-group>
                    <x-ui.form-group name="title">
                        <x-slot name="labelSlot"><label class="text-white/90">Título</label></x-slot>
                        <input type="text" name="title" value="{{ old('title') }}" class="auth-form-input w-full" required>
                    </x-ui.form-group>
                    <x-ui.form-group name="content">
                        <x-slot name="labelSlot"><label class="text-white/90">Contenido (HTML)</label></x-slot>
                        <textarea name="content" rows="8" class="auth-form-input w-full">{{ old('content') }}</textarea>
                    </x-ui.form-group>
                    <x-ui.form-group name="product_id">
                        <x-slot name="labelSlot"><label class="text-white/90">Producto (opcional)</label></x-slot>
                        <select name="product_id" class="auth-form-input w-full">
                            <option value="">Ninguno</option>
                            @foreach($products as $p)
                                <option value="{{ $p->id }}" {{ old('product_id') == $p->id ? 'selected' : '' }}>{{ $p->name }} ({{ $p->key }})</option>
                            @endforeach
                        </select>
                    </x-ui.form-group>
                    <x-ui.form-group name="store_link">
                        <x-slot name="labelSlot"><label class="text-white/90">Enlace tienda</label></x-slot>
                        <input type="url" name="store_link" value="{{ old('store_link') }}" placeholder="https://flatrateimports.store/search?q=..." class="auth-form-input w-full">
                    </x-ui.form-group>
                    <x-ui.form-group name="meta_description">
                        <x-slot name="labelSlot"><label class="text-white/90">Meta descripción</label></x-slot>
                        <textarea name="meta_description" rows="2" class="auth-form-input w-full">{{ old('meta_description') }}</textarea>
                    </x-ui.form-group>
                    <div>
                        <label class="flex items-center gap-2 text-white/90">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                            Activo
                        </label>
                    </div>
                </div>
                <div class="mt-6 flex gap-4">
                    <button type="submit" class="glass-button">Crear</button>
                    <a href="{{ route('admin.seo-pages.index') }}" class="glass-button" style="background: rgba(255,255,255,0.1);">Cancelar</a>
                </div>
            </form>
        </x-ui.card>
    </x-ui.container>
</x-app-layout>
