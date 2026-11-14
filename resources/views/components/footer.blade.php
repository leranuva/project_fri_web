{{-- Footer - Siempre visible; usa configuración de BD o valores por defecto --}}
@php
    $showFooter = $footerSection && $footerSection->is_active;
    $brandName = $showFooter ? $footerSection->brand_name : 'Flat Rate Imports';
@endphp
<footer class="footer">
    <div class="footer-content">
        <a href="{{ route('home') }}" class="footer-brand">
            <div class="footer-logo">
                <x-brand-logo alt="{{ $brandName }}" />
            </div>
            <span>{{ $brandName }}</span>
        </a>
        
        <ul class="footer-links">
            @forelse(($footerLinksForFooter ?? []) as $link)
                <li>
                    <a href="{{ $link->url }}" class="footer-link" {{ str_starts_with($link->url, 'http') ? 'target="_blank" rel="noopener noreferrer"' : '' }}>
                        {{ $link->label }}
                    </a>
                </li>
            @empty
                {{-- Enlaces por defecto si no hay enlaces configurados --}}
                <li><a href="{{ route('home') }}" class="footer-link">Inicio</a></li>
                <li><a href="{{ route('cotizador') }}" class="footer-link">Cotizador</a></li>
                <li><a href="https://flatrateimports.store/" target="_blank" class="footer-link">Tienda</a></li>
                @auth
                    <li><a href="{{ route('dashboard') }}" class="footer-link">Dashboard</a></li>
                @endauth
            @endforelse
        </ul>
        
        <div class="footer-social">
            @foreach(($footerSocials ?? []) as $social)
                @php
                    $socialClass = strtolower(str_replace(' ', '-', $social->label));
                    $platformUrl = match ($socialClass) {
                        'tiktok' => 'https://www.tiktok.com/',
                        'facebook' => 'https://www.facebook.com/',
                        'instagram' => 'https://www.instagram.com/',
                        'whatsapp-business' => 'https://www.whatsapp.com/business/',
                        default => null,
                    };
                    $socialUrl = $platformUrl ?? trim($social->url ?? '');
                    $socialScheme = strtolower(parse_url($socialUrl, PHP_URL_SCHEME) ?? '');
                    $socialPath = parse_url($socialUrl, PHP_URL_PATH);
                    $hasDestination = $platformUrl !== null || (
                        filter_var($socialUrl, FILTER_VALIDATE_URL)
                        && in_array($socialScheme, ['https', 'http'], true)
                        && (app()->environment('local') || trim($socialPath ?: '', '/') !== '')
                    );

                    $label = $hasDestination ? $social->label : $social->label . ' (perfil pendiente)';
                    $tag = $hasDestination ? 'a' : 'span';
                @endphp
                <{{ $tag }} class="social-link social-{{ $socialClass }}" title="{{ $label }}" aria-label="{{ $label }}"
                    @if($hasDestination) href="{{ $socialUrl }}" target="_blank" rel="noopener noreferrer"
                    @else role="img" @endif>
                    @if(in_array($socialClass, ['tiktok', 'facebook', 'instagram', 'whatsapp-business'], true))
                        <img src="{{ asset('brand/social/' . $socialClass . '.svg') }}" alt="" class="social-icon" width="18" height="18">
                    @elseif($social->icon_svg)
                        @php
                            $svg = preg_replace('/<svg\b(?![^>]*\bxmlns\s*=)/i', '<svg xmlns="http://www.w3.org/2000/svg"', $social->icon_svg, 1);
                            $svg = str_ireplace('currentColor', '#fff', $svg);
                        @endphp
                        <img src="data:image/svg+xml;base64,{{ base64_encode($svg) }}" alt="" class="social-icon" width="18" height="18">
                    @else
                        <svg class="social-icon" viewBox="0 0 24 24">
                            <path d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0z"/>
                        </svg>
                    @endif
                </{{ $tag }}>
            @endforeach
        </div>
    </div>
    
    <div class="footer-copy">
        @if($showFooter && $footerSection->copyright_text)
            {!! \App\Support\CmsContent::html(str_replace('{{ date(\'Y\') }}', date('Y'), $footerSection->copyright_text)) !!}
        @else
            © {{ date('Y') }} {{ $brandName }}. All rights reserved.
        @endif
    </div>
</footer>
