@extends('layouts.auth')

@section('content')

<div class="flex min-h-screen items-center justify-center px-5 py-12 sm:px-8">

    <div class="w-full max-w-md">

        <div class="mb-10 text-center">
            <a href="{{ route('home') }}" class="font-display text-3xl font-bold tracking-[0.12em]">
                MORA
            </a>

            <p class="mt-8 text-xs font-bold uppercase tracking-[0.25em] text-mora-accent">
                ACCOUNT RECOVERY.
            </p>

            <h1 class="mt-3 font-display text-4xl font-semibold uppercase">
                Reset Your Password.
            </h1>

            <p class="mt-3 text-sm leading-6 text-mora-muted">
                Enter your email and we'll send you a secure password reset link.
            </p>
        </div>

        <div class="rounded-[10px] border border-mora-border bg-mora-card p-6 sm:p-8">

            @if (session('success'))
            <div class="mb-6 border border-mora-accent/30 bg-mora-accent/5 px-4 py-3 text-sm text-mora-accent">
                {{ session('success') }}
            </div>
            @endif

            <form action="{{ route('password.email') }}" method="POST">
                @csrf

                <label for="email" class="mb-2 block text-xs font-bold uppercase tracking-[0.15em]">
                    Email
                </label>

                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="email" class="w-full rounded-[6px] border border-mora-border bg-mora-surface px-4 py-3.5 text-sm outline-none transition focus:border-mora-accent" placeholder="you@example.com">

                @error('email')
                <p class="mt-2 text-xs text-red-400">
                    {{ $message }}
                </p>
                @enderror

                <button type="submit" class="mt-6 w-full rounded-[6px] bg-mora-accent px-6 py-4 text-sm font-bold uppercase tracking-wide text-black transition hover:bg-mora-accent-hover">
                    Send Reset Link
                </button>
            </form>

        </div>

        <p class="mt-8 text-center text-sm text-mora-muted">
            Remember your password?

            <a href="{{ route('login') }}" class="font-semibold text-mora-text transition hover:text-mora-accent">
                Back to Sign In
            </a>
        </p>

    </div>

</div>

@endsection
