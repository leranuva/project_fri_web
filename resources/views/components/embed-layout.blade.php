@props(['title' => 'Cotizador'])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }} | {{ config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { margin: 0; padding: 1rem; min-height: 100vh; background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%); }
    </style>
</head>
<body class="font-sans antialiased">
    <div class="max-w-4xl mx-auto">
        <p class="text-white/90 text-sm mb-4">Cotizador por <a href="{{ url('/') }}" target="_blank" class="underline">Flat Rate Imports</a></p>
        {{ $slot }}
    </div>
</body>
</html>
