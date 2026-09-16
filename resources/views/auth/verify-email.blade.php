@extends('layouts.auth')

@section('content')

<div class="flex min-h-screen items-center justify-center px-5 py-12 sm:px-8">

    <div class="w-full max-w-md text-center">

        <a href="{{ route('home') }}" class="font-display text-3xl font-bold tracking-[0.12em]">
            MORA
        </a>

        <div class="mt-12 rounded-[10px] border border-mora-border bg-mora-card p-7 sm:p-9">

            <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full border border-mora-accent/30 bg-mora-accent/5 text-mora-accent">
                ✓
            </div>

            <p class="mt-7 text-xs font-bold uppercase tracking-[0.25em] text-mora-accent">
                خطوة أخيرة.
            </p>

            <h1 class="mt-3 font-display text-4xl font-semibold uppercase">
                فعّل بريدك الإلكتروني.
            </h1>

            <p class="mt-4 text-sm leading-7 text-mora-muted">
                We sent a verification link to your email address.
                Please check your inbox and click the link to activate your account.
            </p>

            @if (session('success'))
            <div class="mt-6 border border-mora-accent/30 bg-mora-accent/5 px-4 py-3 text-sm text-mora-accent">
                {{ session('success') }}
            </div>
            @endif

            <form action="{{ route('verification.send') }}" method="POST" class="mt-7">
                @csrf

                <button type="submit" class="w-full rounded-[6px] bg-mora-accent px-6 py-4 text-sm font-bold uppercase tracking-wide text-black transition hover:bg-mora-accent-hover">
                    إعادة إرسال رسالة التفعيل
                </button>
            </form>

            <form action="{{ route('logout') }}" method="POST" class="mt-4">
                @csrf

                <button type="submit" class="text-xs font-semibold uppercase tracking-wide text-mora-muted transition hover:text-mora-accent">
                    تسجيل الخروج
                </button>
            </form>

        </div>

    </div>

</div>

@endsection
