<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Token CSRF per le richieste JavaScript (axios lo legge da qui) --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Descrizione della pagina, letta dai motori di ricerca --}}
    <meta name="description" content="{{ $metaDescription ?? 'Blog sviluppato con Laravel 12' }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Titolo nella scheda del browser: "Pagina · Auth & Posts" --}}
    <title>{{ isset($pageTitle) ? $pageTitle . ' · ' : '' }}Auth &amp; Posts</title>
</head>