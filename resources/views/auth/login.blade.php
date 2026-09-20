@extends('layouts.auth')

@section('content')

<div class="grid min-h-screen lg:grid-cols-2">

    {{-- Brand Side --}}
    <div class="relative hidden overflow-hidden border-r border-mora-border lg:flex">

        <div class="absolute inset-0 bg-[radial-gradient(circle_at_center,rgba(200,255,0,0.08),transparent_50%)]"></div>

        <div class="relative flex w-full flex-col justify-between p-12 xl:p-16">

            <a href="{{ route('home') }}" class="inline-flex items-center gap-3">
                <span class="font-display text-3xl font-bold tracking-tight">
                    M
                </span>

                <span class="font-display text-2xl font-bold tracking-[0.12em]">
                    MORA
                </span>
            </a>

            <div>
                <p class="mb-4 text-xs font-bold uppercase tracking-[0.3em] text-mora-accent">
                    مرحبًا بعودتك.
                </p>

                <h1 class="max-w-xl font-display text-6xl font-semibold uppercase leading-[0.9] tracking-tight xl:text-8xl">
                    تدرّب.
                    <br>
                    <span class="text-mora-accent">تحدَّ نفسك.</span>
                    <br>
                    كرّر.
                </h1>

                <p class="mt-7 max-w-md text-sm leading-7 text-mora-muted">
                    تقدّمك يبدأ بالاستمرارية.
                    سجّل الدخول وواصل التقدّم.
                </p>
            </div>

            <p class="text-xs uppercase tracking-[0.2em] text-mora-muted">
                MORA GYM — أقوى كل يوم.
            </p>

        </div>
    </div>


    {{-- Form Side --}}
    <div class="flex items-center justify-center px-5 py-12 sm:px-8">

        <div class="w-full max-w-md">

            <div class="mb-10 lg:hidden">
                <a href="{{ route('home') }}" class="font-display text-3xl font-bold tracking-[0.12em]">
                    MORA
                </a>
            </div>

            <div class="mb-8">
                <p class="mb-3 text-xs font-bold uppercase tracking-[0.25em] text-mora-accent">
                    دخول الأعضاء
                </p>

                <h2 class="font-display text-4xl font-semibold uppercase">
                    مرحبًا بعودتك.
                </h2>

                <p class="mt-3 text-sm text-mora-muted">
                    سجّل الدخول للوصول إلى حسابك في MORA.
                </p>
            </div>


            @if (session('success'))
            <div class="mb-6 border border-mora-accent/30 bg-mora-accent/5 px-4 py-3 text-sm text-mora-accent">
                {{ session('success') }}
            </div>
            @endif


            <form action="{{ route('login.store') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="mb-2 block text-xs font-bold uppercase tracking-[0.15em]">
                        البريد الإلكتروني
                    </label>

                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="email" class="w-full rounded-[6px] border border-mora-border bg-mora-card px-4 py-3.5 text-sm outline-none transition placeholder:text-mora-muted/50 focus:border-mora-accent" placeholder="example@email.com">

                    @error('email')
                    <p class="mt-2 text-xs text-red-400">
                        {{ $message }}
                    </p>
                    @enderror
                </div>


                <div>
                    <div class="mb-2 flex items-center justify-between gap-4">
                        <label for="password" class="block text-xs font-bold uppercase tracking-[0.15em]">
                            كلمة المرور
                        </label>

                        <a href="{{ route('password.request') }}" class="text-xs text-mora-muted transition hover:text-mora-accent">
                            هل نسيت كلمة المرور؟
                        </a>
                    </div>

                    <input id="password" type="password" name="password" required autocomplete="current-password" class="w-full rounded-[6px] border border-mora-border bg-mora-card px-4 py-3.5 text-sm outline-none transition focus:border-mora-accent" placeholder="••••••••">

                    @error('password')
                    <p class="mt-2 text-xs text-red-400">
                        {{ $message }}
                    </p>
                    @enderror
                </div>


                <label class="flex cursor-pointer items-center gap-3">
                    <input type="checkbox" name="remember" value="1" class="h-4 w-4 rounded border-mora-border bg-mora-card accent-[#c8ff00]">

                    <span class="text-xs text-mora-muted">
                        تذكرني
                    </span>
                </label>


                <button type="submit" class="flex w-full items-center justify-center rounded-[6px] bg-mora-accent px-6 py-4 text-sm font-bold uppercase tracking-wide text-black transition hover:bg-mora-accent-hover">
                    تسجيل الدخول
                </button>

            </form>


            <p class="mt-8 text-center text-sm text-mora-muted">
                ليس لديك حساب؟

                <a href="{{ route('register') }}" class="font-semibold text-mora-text transition hover:text-mora-accent">
                    إنشاء حساب
                </a>
            </p>

        </div>

    </div>

</div>

@endsection
