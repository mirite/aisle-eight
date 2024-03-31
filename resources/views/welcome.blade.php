<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Grocery Mate</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased bg-white-100 text-bg-900 dark:text-white dark:bg-slate-900">
    <div class="flex flex-col justify-center items-center min-h-dvh">
        <h1>Welcome to Aisle Eight</h1>
        @if (Route::has('login'))
            <livewire:welcome.navigation />
        @endif
    </div>
</body>

</html>
