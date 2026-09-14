<!DOCTYPE html>
<html lang="en" class="bg-mora-bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'MORA GYM' }}</title>

    @vite([
    'resources/css/app.css',
    'resources/js/app.js'
    ])
</head>

<body class="min-h-screen bg-mora-bg text-mora-text antialiased">

    <main class="min-h-screen">
        @yield('content')
    </main>

</body>
</html>
