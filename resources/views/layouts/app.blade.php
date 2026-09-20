<!DOCTYPE html>
<html lang="ar" dir="rtl" class="bg-mora-bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#0A0A0A">

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
    @if (session('success') || session('error') || session('info') || $errors->any())
    <div class="fixed left-5 right-5 top-24 z-50 mx-auto max-w-xl lg:right-[19rem]" x-data="{ open: true }" x-show="open" x-cloak x-transition>
        @if (session('success'))
        <div class="rounded-lg border border-mora-accent/20 bg-mora-card p-4 shadow-2xl">
            <div class="flex items-start gap-4">
                <p class="flex-1 text-sm font-medium text-mora-accent">
                    {{ session('success') }}
                </p>

                <button @click="open = false" type="button" class="text-mora-muted transition hover:text-mora-text" aria-label="إغلاق الرسالة">
                    ×
                </button>
            </div>
        </div>
        @elseif (session('error'))
        <div class="rounded-lg border border-red-500/20 bg-mora-card p-4 shadow-2xl">
            <div class="flex items-start gap-4">
                <p class="flex-1 text-sm font-medium text-red-400">
                    {{ session('error') }}
                </p>

                <button @click="open = false" type="button" class="text-mora-muted transition hover:text-mora-text" aria-label="إغلاق الرسالة">
                    ×
                </button>
            </div>
        </div>
        @elseif (session('info'))
        <div class="rounded-lg border border-yellow-500/20 bg-mora-card p-4 shadow-2xl">
            <div class="flex items-start gap-4">
                <p class="flex-1 text-sm font-medium text-yellow-400">
                    {{ session('info') }}
                </p>

                <button @click="open = false" type="button" class="text-mora-muted transition hover:text-mora-text" aria-label="إغلاق الرسالة">
                    ×
                </button>
            </div>
        </div>
        @elseif ($errors->any())
        <div class="rounded-lg border border-red-500/20 bg-mora-card p-4 shadow-2xl">
            <div class="flex items-start gap-4">
                <div class="min-w-0 flex-1">
                    <p class="text-sm font-semibold text-red-400">
                        يرجى مراجعة البيانات المدخلة.
                    </p>

                    <ul class="mt-2 space-y-1 text-xs leading-6 text-red-300/90">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>

                <button @click="open = false" type="button" class="text-mora-muted transition hover:text-mora-text" aria-label="إغلاق الرسالة">
                    ×
                </button>
            </div>
        </div>
        @endif
    </div>
    @endif

    >>>>>>> c3187b6 (feat: complete arabic security and admin audit)
    <main class="{{ $isAdminArea ? 'min-h-screen lg:pr-72 pt-16 lg:pt-0' : '' }}">
        @yield('content')
    </main>

    @unless ($isAdminArea)
    @include('components.footer')
    @endunless

</body>
</html>
