@extends('layouts.auth')

@section('content')

<div class="flex min-h-screen items-center justify-center px-5 py-12 sm:px-8">

    <div class="w-full max-w-md">

        <div class="mb-10 text-center">

            <a href="{{ route('home') }}" class="font-display text-3xl font-bold tracking-[0.12em]">
                MORA
            </a>

            <p class="mt-8 text-xs font-bold uppercase tracking-[0.25em] text-mora-accent">
                NEW PASSWORD.
            </p>

            <h1 class="mt-3 font-display text-4xl font-semibold uppercase">
                Create A New Password.
            </h1>

        </div>

        <div class="rounded-[10px] border border-mora-border bg-mora-card p-6 sm:p-8">

            <form action="{{ route('password.update') }}" method="POST" class="space-y-5">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

                <div>
                    <label for="email" class="mb-2 block text-xs font-bold uppercase tracking-[0.15em]">
                        Email
                    </label>

                    <input id="email" type="email" name="email" value="{{ old('email', $email) }}" required autocomplete="email" class="w-full rounded-[6px] border border-mora-border bg-mora-surface px-4 py-3.5 text-sm outline-none transition focus:border-mora-accent">

                    @error('email')
                    <p class="mt-2 text-xs text-red-400">
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="mb-2 block text-xs font-bold uppercase tracking-[0.15em]">
                        New Password
                    </label>

                    <input id="password" type="password" name="password" required autocomplete="new-password" class="w-full rounded-[6px] border border-mora-border bg-mora-surface px-4 py-3.5 text-sm outline-none transition focus:border-mora-accent">

                    @error('password')
                    <p class="mt-2 text-xs text-red-400">
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="mb-2 block text-xs font-bold uppercase tracking-[0.15em]">
                        Confirm Password
                    </label>

                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" class="w-full rounded-[6px] border border-mora-border bg-mora-surface px-4 py-3.5 text-sm outline-none transition focus:border-mora-accent">
                </div>

                <button type="submit" class="w-full rounded-[6px] bg-mora-accent px-6 py-4 text-sm font-bold uppercase tracking-wide text-black transition hover:bg-mora-accent-hover">
                    Reset Password
                </button>

            </form>

        </div>

    </div>

</div>

@endsection
