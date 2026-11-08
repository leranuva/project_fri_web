<section aria-label="Vista previa del tema" class="space-y-3">
    <div class="flex flex-wrap items-center justify-between gap-2">
        <h3 class="font-semibold">Vista previa</h3>
        <div class="flex gap-2" aria-label="Tamaño de vista previa">
            <button type="button" data-preview-size="desktop" aria-pressed="true" class="rounded-lg border border-white/20 bg-white/5 px-3 py-1.5 text-sm text-white transition-colors hover:bg-white/10 aria-pressed:bg-white/20">Escritorio</button>
            <button type="button" data-preview-size="mobile" aria-pressed="false" class="rounded-lg border border-white/20 bg-white/5 px-3 py-1.5 text-sm text-white transition-colors hover:bg-white/10 aria-pressed:bg-white/20">Móvil</button>
        </div>
    </div>

    <div class="theme-preview mx-auto w-full space-y-4 rounded-xl p-4" data-theme-preview data-size="desktop"
         style="{{ \App\Support\ThemePalette::cssVariables($palette) }}">
        <div class="theme-preview-nav theme-surface flex flex-wrap items-center justify-between gap-2 rounded-xl p-2">
            <span class="brand-text px-2 font-semibold">Flat Rate Imports</span>
            <span class="nav-link active theme-nav-active">Inicio</span>
        </div>

        <div class="theme-surface space-y-2 rounded-xl p-4">
            <p class="theme-text-primary text-lg font-semibold">Importa tus compras</p>
            <p class="theme-text-secondary text-sm">Recibe tus paquetes en Ecuador.</p>
        </div>

        <button type="button" class="glass-button glass-button-sm theme-focus">Cotizar mi envío</button>
    </div>

    <div class="rounded-xl border border-white/10 bg-white/5 p-4 text-sm">
        <p class="font-semibold">Contraste estimado</p>
        <p class="text-white/80">Mínimos sobre muestras del degradado. Incluye la transparencia de la tarjeta y del botón.</p>
        <ul data-theme-contrast class="mt-2 space-y-1" aria-live="polite"></ul>
    </div>
</section>
