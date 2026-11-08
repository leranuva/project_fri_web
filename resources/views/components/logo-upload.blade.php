@props(['required' => false, 'current' => null])

<div>
    <x-input-label for="logo_image" :value="$required ? 'Imagen del logo' : 'Nueva imagen del logo (opcional)'" class="text-white/90 mb-2" />
    <input id="logo_image" name="logo_image" type="file" class="auth-form-input"
        accept="{{ \App\Support\LogoImage::ACCEPT }}" @required($required)>
    <p class="mt-1 text-xs text-white/80">
        {{ \App\Support\LogoImage::FORMATS }}. Máximo 5 MB. El recorte elimina el margen transparente antes de ajustar la imagen.
    </p>
    <x-input-error class="mt-2" :messages="$errors->get('logo_image')" />
    <p id="logo-preview-status" role="status" class="mt-2 text-sm text-white/90"></p>

    <div id="logo-preview" @class(['mt-4 flex flex-wrap gap-5', 'hidden' => ! $current])>
        @foreach(['Cabecera' => 68, 'Móvil' => 56, 'Pie' => 52] as $label => $size)
            <div class="text-center">
                <p class="mb-2 text-xs text-white/80">{{ $label }}</p>
                <div class="{{ $label === 'Pie' ? 'footer-logo' : 'logo-icon' }} mx-auto" style="--brand-logo-size: {{ $size }}px;">
                    <img @if($current) src="{{ $current }}" @endif alt="" data-logo-preview>
                </div>
                <p class="mt-1 text-xs text-white/70" data-logo-dimensions></p>
            </div>
        @endforeach
    </div>
</div>

<script>
    (() => {
        const input = document.getElementById('logo_image');
        const preview = document.getElementById('logo-preview');
        const status = document.getElementById('logo-preview-status');
        const images = [...preview.querySelectorAll('[data-logo-preview]')];
        const current = images[0].getAttribute('src');
        let request;
        let previewUrl;

        for (const image of images) {
            const dimensions = image.parentElement.nextElementSibling;
            const measure = () => {
                if (!image.naturalWidth) return;
                const scale = Math.min(image.clientWidth / image.naturalWidth, image.clientHeight / image.naturalHeight);
                dimensions.textContent = Math.round(image.naturalWidth * scale) + ' × '
                    + Math.round(image.naturalHeight * scale) + ' px';
            };
            image.addEventListener('load', measure);
            if (image.complete) measure();
        }

        input.addEventListener('change', async () => {
            request?.abort();
            if (previewUrl) URL.revokeObjectURL(previewUrl);
            previewUrl = null;
            for (const image of images) {
                if (current) image.src = current;
                else {
                    image.removeAttribute('src');
                    image.parentElement.nextElementSibling.textContent = '';
                }
            }
            preview.classList.toggle('hidden', !current);
            const file = input.files[0];
            status.textContent = file ? 'Preparando vista previa…' : '';
            if (!file) return;

            const pending = new AbortController();
            request = pending;
            const form = new FormData();
            form.append('logo_image', file);
            form.append('_token', input.form.elements._token.value);

            try {
                const response = await fetch(@js(route('admin.logos.preview')), {
                    method: 'POST', body: form, headers: {Accept: 'application/json'}, signal: pending.signal,
                });
                if (!response.ok) {
                    const error = await response.json();
                    throw new Error(error.errors?.logo_image?.[0]
                        || (response.status === 503 ? error.message : '')
                        || 'No se pudo generar la vista previa.');
                }
                const image = await response.blob();
                if (pending.signal.aborted) return;
                previewUrl = URL.createObjectURL(image);
                for (const item of images) item.src = previewUrl;
                preview.classList.remove('hidden');
                status.textContent = '';
            } catch (error) {
                if (!pending.signal.aborted) status.textContent = error.message;
            }
        });
    })();
</script>
