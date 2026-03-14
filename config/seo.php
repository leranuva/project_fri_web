<?php

return [

    /*
    |--------------------------------------------------------------------------
    | SEO & Analytics Configuration
    |--------------------------------------------------------------------------
    |
    | Configuración para SEO técnico, analítica y tracking de conversiones.
    |
    */

    'default_title' => env('SEO_DEFAULT_TITLE', 'Flat Rate Imports - Importa desde USA a Ecuador'),
    'default_description' => env('SEO_DEFAULT_DESCRIPTION', 'Cotiza tu envío desde USA a Ecuador. Casillero postal, importaciones, tracking de paquetes.'),
    'default_image' => env('SEO_DEFAULT_IMAGE', '/logo_fri.png'),

    'google_analytics_id' => env('GOOGLE_ANALYTICS_ID', ''),
    'posthog_key' => env('POSTHOG_KEY', ''),
    'posthog_host' => env('POSTHOG_HOST', 'https://us.i.posthog.com'),

    'store_url' => env('ECOMMERCE_STORE_URL', 'https://flatrateimports.store'),
    'store_search_path' => '/search',

    /*
    |--------------------------------------------------------------------------
    | Webhooks (Fase 12 - n8n, Zapier)
    |--------------------------------------------------------------------------
    */
    'webhook_leads_url' => env('WEBHOOK_LEADS_URL', ''),
    'webhook_quotes_url' => env('WEBHOOK_QUOTES_URL', ''),

];
