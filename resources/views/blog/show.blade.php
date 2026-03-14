<x-guest-layout :seoTitle="$seoTitle" :seoDescription="$seoDescription" :seoImage="$seoImage ?? $post->featured_image_url">
    <div class="py-12 sm:py-16">
        <x-ui.container>
            <a href="{{ route('blog.index') }}" class="inline-flex items-center text-white/80 hover:text-white transition-colors mb-8">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Volver al blog
            </a>

            <x-ui.card glassmorphism="true" padding="lg">
                @if($post->featured_image_url)
                    <div class="w-full max-w-2xl mx-auto mb-8 rounded-lg overflow-hidden">
                        <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}" class="w-full h-auto" loading="eager">
                    </div>
                @endif
                <h1 class="text-3xl sm:text-4xl font-bold text-white mb-6">{{ $post->title }}</h1>
                @if($post->excerpt)
                    <p class="text-lg text-white/80 mb-8">{{ $post->excerpt }}</p>
                @endif
                <div class="prose prose-invert max-w-none text-white/90">
                    {!! nl2br(e($post->content ?? '')) !!}
                </div>
                @if($post->link)
                    <a href="{{ $post->link }}" target="_blank" rel="noopener" class="auth-form-link inline-flex items-center gap-2 mt-8">
                        Enlace externo
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                    </a>
                @endif

                {{-- CTA Tienda --}}
                @php
                    $ctaVisible = ($blogSection?->cta_button_visible ?? true) && ($post->cta_active ?? true);
                    $ctaUrl = ($post->cta_link && filter_var($post->cta_link, FILTER_VALIDATE_URL)) ? $post->cta_link : ($blogSection?->cta_button_url_base ?? config('seo.store_url'));
                    $ctaLabel = $post->cta_text ?: ($blogSection?->cta_button_text ?? 'Ir a la tienda');
                    $ctaAnimated = $blogSection?->cta_button_animated ?? true;
                @endphp
                @if($ctaVisible)
                <div class="mt-10 pt-8 border-t border-white/20">
                    <a 
                        href="{{ $ctaUrl }}" 
                        target="_blank" 
                        rel="noopener"
                        class="{{ $ctaAnimated ? 'blog-cta-button ' : '' }}inline-flex items-center gap-2 px-5 py-3.5 rounded-xl font-bold text-base"
                        style="background: {{ $blogSection?->cta_button_bg_color ?? 'rgba(34, 197, 94, 0.2)' }}; border: 2px solid {{ $blogSection?->cta_button_border_color ?? 'rgba(34, 197, 94, 0.4)' }}; color: {{ $blogSection?->cta_button_text_color ?? '#86efac' }};"
                    >
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 0 0-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        {{ $ctaLabel }}
                    </a>
                </div>
                @endif
            </x-ui.card>
        </x-ui.container>
    </div>
</x-guest-layout>
