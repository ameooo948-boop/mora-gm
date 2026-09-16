<!DOCTYPE html>
<html lang="ar" dir="rtl" class="bg-mora-bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'MORA GYM' }}</title>

    <meta name="description" content="{{ $description ?? 'MORA GYM — أقوى كل يوم.' }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-mora-bg text-mora-text antialiased">

    @include('components.navbar')

    <main>
        @yield('content')
    </main>

    @include('components.footer')

</body>
</html>
