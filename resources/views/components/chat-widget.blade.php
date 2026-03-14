{{-- Widget de Chat en Vivo (Tidio o Crisp) --}}
@php
    // Configuración del widget de chat
    $chatProvider = config('app.chat_provider', env('CHAT_PROVIDER', 'tidio')); // 'tidio' o 'crisp'
    $tidioPublicKey = config('app.tidio_public_key', env('TIDIO_PUBLIC_KEY', ''));
    $crispWebsiteId = config('app.crisp_website_id', env('CRISP_WEBSITE_ID', ''));
@endphp

@if($chatProvider === 'tidio' && !empty($tidioPublicKey))
    {{-- Tidio Chat Widget --}}
    <script src="//code.tidio.co/{{ $tidioPublicKey }}.js" async></script>
@elseif($chatProvider === 'crisp' && !empty($crispWebsiteId))
    {{-- Crisp Chat Widget --}}
    <script type="text/javascript">
        window.$crisp=[];
        window.CRISP_WEBSITE_ID="{{ $crispWebsiteId }}";
        (function(){
            d=document;
            s=d.createElement("script");
            s.src="https://client.crisp.chat/l.js";
            s.async=1;
            d.getElementsByTagName("head")[0].appendChild(s);
        })();
    </script>
@endif

