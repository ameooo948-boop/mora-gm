<!DOCTYPE html>
<html lang="ar" dir="rtl" class="bg-mora-bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $code ?? 'MORA GYM' }} — MORA GYM</title>
    <meta name="description" content="{{ $message ?? 'حدث خطأ غير متوقع.' }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-mora-bg text-mora-text antialiased">
    <main class="flex min-h-screen items-center justify-center px-5 py-16">
        <div class="w-full max-w-2xl text-center">
            <a href="{{ route('home') }}" class="font-display text-4xl font-bold tracking-[0.12em]">MORA</a>
            @yield('content')
        </div>
    </main>
</body>
</html>
