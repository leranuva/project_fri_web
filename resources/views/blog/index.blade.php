<x-guest-layout>
    <div class="py-12 sm:py-16">
        <x-ui.container>
            <div class="text-center mb-12">
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-white mb-4">
                    {{ optional($blogSection)->title ?? 'Temas de Interés' }}
                </h1>
                @if($blogSection && $blogSection->subtitle)
                    <p class="text-lg text-white/80 max-w-2xl mx-auto">{{ $blogSection->subtitle }}</p>
                @endif
            </div>

            <x-ui.grid :cols="1" :cols-sm="2" :cols-md="3" gap="default">
                @forelse($posts as $post)
                    <x-ui.card glassmorphism="true" class="blog-card h-full flex flex-col">
                        <a href="{{ url('/blog/' . $post->id . '-' . \Illuminate\Support\Str::slug($post->title)) }}" class="flex flex-col flex-1">
                            @if($post->featured_image_url)
                                <div class="w-full h-48 overflow-hidden rounded-lg mb-4 bg-white/5">
                                    <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}" class="w-full h-full object-cover" loading="lazy">
                                </div>
                            @endif
                            <div class="flex-1 flex flex-col">
                                <h2 class="text-xl font-semibold text-white mb-2 line-clamp-2">{{ $post->title }}</h2>
                                @if($post->excerpt)
                                    <p class="text-white/80 text-sm line-clamp-3 flex-1">{{ $post->excerpt }}</p>
                                @endif
                                <span class="auth-form-link text-sm font-semibold mt-4 inline-flex items-center gap-1">
                                    Leer más
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </span>
                            </div>
                        </a>
                        @php
                            $ctaVisible = ($blogSection?->cta_button_visible ?? true) && ($post->cta_active ?? true);
                            $ctaUrl = ($post->cta_link && filter_var($post->cta_link, FILTER_VALIDATE_URL)) ? $post->cta_link : ($blogSection?->cta_button_url_base ?? config('seo.store_url'));
                            $ctaLabel = $post->cta_text ?: ($blogSection?->cta_button_text ?? 'Ir a la tienda');
                            $ctaAnimated = $blogSection?->cta_button_animated ?? true;
                        @endphp
                        @if($ctaVisible)
                        <a href="{{ $ctaUrl }}" target="_blank" rel="noopener" class="{{ $ctaAnimated ? 'blog-cta-button ' : '' }}inline-flex items-center gap-2 px-4 py-2.5 rounded-xl font-bold text-sm w-full mt-4 justify-center"
                            style="background: {{ $blogSection?->cta_button_bg_color ?? 'rgba(34, 197, 94, 0.2)' }}; border: 2px solid {{ $blogSection?->cta_button_border_color ?? 'rgba(34, 197, 94, 0.4)' }}; color: {{ $blogSection?->cta_button_text_color ?? '#86efac' }};"
                        >
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 0 0-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                            {{ $ctaLabel }}
                        </a>
                        @endif
                    </x-ui.card>
                @empty
                    <div class="col-span-full text-center py-12 text-white/80">
                        <p>No hay artículos publicados aún.</p>
                        <a href="{{ route('home') }}" class="auth-form-link mt-4 inline-block">Volver al inicio</a>
                    </div>
                @endforelse
            </x-ui.grid>

            @if($posts->hasPages())
                <div class="mt-12 flex justify-center">{{ $posts->links() }}</div>
            @endif
        </x-ui.container>
    </div>
</x-guest-layout>
