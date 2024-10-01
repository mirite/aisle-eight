<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Aisle Eight') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased bg-white-100 text-bg-900 dark:text-white dark:bg-slate-900 m-0">
    <main class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8 w-full grow flex flex-col items-center [&>*]:w-full">
        {{ $slot }}
    </main>
    <footer class="mx-auto text-center max-w-screen-2xl w-full p-4">
        <a href="https://jesseconner.ca" target="_blank">&copy;Jesse Conner {{ date('Y') }}</a>
    </footer>
</body>

</html>
