{{-- Botón Flotante de Mensajería Red Móvil --}}
@php
    // Obtener número de Red Móvil desde configuración o variable de entorno
    $redMovilNumber = config('app.red_movil_number', env('RED_MOVIL_NUMBER', '593999999999')); // Formato: código país + número sin espacios
    $redMovilMessage = config('app.red_movil_message', env('RED_MOVIL_MESSAGE', 'Hola, me interesa conocer más sobre sus servicios de importación.'));
    
    // Construir URL de SMS (Red Móvil)
    $redMovilUrl = 'sms:' . $redMovilNumber . '?body=' . urlencode($redMovilMessage);
@endphp

<a 
    href="{{ $redMovilUrl }}" 
    class="messenger-float"
    aria-label="Contactar por Mensajería Red Móvil"
    title="Contáctanos por Mensajería Red Móvil"
>
    <div class="messenger-float-icon">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg">
            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
        </svg>
    </div>
    <div class="messenger-float-pulse"></div>
</a>

<style>
.messenger-float {
    position: fixed;
    bottom: 90px;
    right: 20px;
    width: 60px;
    height: 60px;
    background: #001F3F;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 12px rgba(0, 31, 63, 0.4);
    z-index: 1000;
    transition: all 0.3s ease;
    text-decoration: none;
    overflow: visible;
}

.messenger-float:hover {
    transform: scale(1.1);
    box-shadow: 0 6px 20px rgba(0, 31, 63, 0.6);
    background: #001529;
}

.messenger-float-icon {
    width: 32px;
    height: 32px;
    color: white;
    position: relative;
    z-index: 2;
}

.messenger-float-icon svg {
    width: 100%;
    height: 100%;
}

.messenger-float-pulse {
    position: absolute;
    width: 100%;
    height: 100%;
    border-radius: 50%;
    background: #001F3F;
    opacity: 0.6;
    animation: messenger-pulse 2s ease-out infinite;
}

@keyframes messenger-pulse {
    0% {
        transform: scale(1);
        opacity: 0.6;
    }
    50% {
        transform: scale(1.2);
        opacity: 0.3;
    }
    100% {
        transform: scale(1.4);
        opacity: 0;
    }
}

/* Responsive */
@media (max-width: 640px) {
    .messenger-float {
        width: 56px;
        height: 56px;
        bottom: 85px;
        right: 15px;
    }
    
    .messenger-float-icon {
        width: 28px;
        height: 28px;
    }
}
</style>

