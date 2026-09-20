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

    @php($isAdminArea = auth()->check() && auth()->user()->isAdmin() && request()->is('admin/*'))

    @if ($isAdminArea)
        @include('components.admin.sidebar')
    @else
        @include('components.navbar')
    @endif

    {{-- رسائل النظام --}}
    @if (session('success'))
        <div class="fixed left-5 right-5 top-24 z-50 mx-auto max-w-xl rounded-lg border border-mora-accent/20 bg-mora-card p-4 shadow-2xl lg:right-[19rem]">
            <p class="text-sm font-medium text-mora-accent">
                {{ session('success') }}
            </p>
        </div>
    @endif

    @if (session('error'))
        <div class="fixed left-5 right-5 top-24 z-50 mx-auto max-w-xl rounded-lg border border-red-500/20 bg-mora-card p-4 shadow-2xl lg:right-[19rem]">
            <p class="text-sm font-medium text-red-400">
                {{ session('error') }}
            </p>
        </div>
    @endif

    @if (session('info'))
        <div class="fixed left-5 right-5 top-24 z-50 mx-auto max-w-xl rounded-lg border border-yellow-500/20 bg-mora-card p-4 shadow-2xl lg:right-[19rem]">
            <p class="text-sm font-medium text-yellow-400">
                {{ session('info') }}
            </p>
        </div>
    @endif

    <main class="{{ $isAdminArea ? 'min-h-screen lg:pr-72 pt-16 lg:pt-0' : '' }}">
        @yield('content')
    </main>

    @unless ($isAdminArea)
        @include('components.footer')
    @endunless

</body>
</html>
