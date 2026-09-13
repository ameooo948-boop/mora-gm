@extends('layouts.app')

@section('content')

<section class="relative isolate min-h-[100svh] overflow-hidden bg-mora-bg">

    {{-- Background Image --}}
    <div class="absolute inset-0 -z-10">

        <img src="{{ asset('images/hero/gym-hero.webp') }}" alt="MORA Gym" class="h-full w-full object-cover object-center">

        {{-- Overall dark overlay --}}
        <div class="absolute inset-0 bg-black/50"></div>

        {{-- Left side readability --}}
        <div class="absolute inset-0 bg-gradient-to-r from-black via-black/65 to-black/20"></div>

        {{-- Bottom fade --}}
        <div class="absolute inset-x-0 bottom-0 h-48 bg-gradient-to-t from-black to-transparent"></div>

    </div>


    {{-- Main Content --}}
    <div class="mx-auto flex min-h-[calc(100svh-5rem)] max-w-7xl items-center px-5 pb-40 pt-32 sm:px-8 lg:px-10">

        <div class="max-w-4xl">

            {{-- Eyebrow --}}
            <div class="mb-6 flex items-center gap-3">

                <span class="h-px w-10 bg-mora-accent"></span>

                <span class="text-[10px] font-semibold uppercase tracking-[0.3em] text-mora-accent sm:text-xs">
                    MORA GYM / FITNESS
                </span>

            </div>


            {{-- Heading --}}
            <h1 class="font-display text-[clamp(3.8rem,7vw,7rem)] font-bold uppercase leading-[0.84] tracking-[-0.025em]">

                Train
                <br>

                <span class="text-mora-accent">
                    Harder.
                </span>

                <br>

                Live
                <br>

                Stronger.

            </h1>


            {{-- Description --}}
            <p class="mt-7 max-w-xl text-sm leading-7 text-white/65 sm:text-base sm:leading-8">
                A focused space to train, improve, and become stronger every day.
                Professional guidance, quality equipment, and a community built around progress.
            </p>


            {{-- Actions --}}
            <div class="mt-8 flex flex-col gap-3 sm:flex-row">

                <a href="#memberships" class="group inline-flex items-center justify-center gap-4 bg-mora-accent px-7 py-4 text-xs font-bold tracking-[0.15em] text-black transition-all duration-300 hover:bg-mora-accent-hover">
                    JOIN NOW

                    <span class="text-base transition-transform duration-300 group-hover:translate-x-1">
                        →
                    </span>
                </a>

                <a href="#about" class="inline-flex items-center justify-center border border-white/20 px-7 py-4 text-xs font-bold tracking-[0.15em] text-white transition-all duration-300 hover:border-white/40 hover:bg-white/5">
                    DISCOVER MORA
                </a>

            </div>

        </div>

    </div>


    {{-- Stats --}}
    <div class="absolute inset-x-0 bottom-0 border-t border-white/10 bg-black/35 backdrop-blur-md">

        <div class="mx-auto grid max-w-7xl grid-cols-3 divide-x divide-white/10">

            <div class="px-5 py-5 sm:px-8 lg:px-10">
                <p class="font-display text-2xl font-semibold sm:text-3xl">
                    150<span class="text-mora-accent">m²</span>
                </p>

                <p class="mt-1 text-[9px] uppercase tracking-[0.2em] text-white/45 sm:text-[10px]">
                    Training Space
                </p>
            </div>


            <div class="px-5 py-5 sm:px-8 lg:px-10">
                <p class="font-display text-2xl font-semibold sm:text-3xl">
                    01
                </p>

                <p class="mt-1 text-[9px] uppercase tracking-[0.2em] text-white/45 sm:text-[10px]">
                    Professional Trainer
                </p>
            </div>


            <div class="px-5 py-5 sm:px-8 lg:px-10">
                <p class="font-display text-2xl font-semibold sm:text-3xl">
                    02
                </p>

                <p class="mt-1 text-[9px] uppercase tracking-[0.2em] text-white/45 sm:text-[10px]">
                    Daily Sessions
                </p>
            </div>

        </div>

    </div>

</section>

<section id="sessions" class="relative border-b border-mora-border bg-mora-bg py-24 sm:py-28 lg:py-36">
    <div class="mx-auto max-w-7xl px-5 sm:px-8 lg:px-10">

        {{-- Header --}}
        <div class="grid gap-8 lg:grid-cols-[1fr_0.65fr] lg:items-end">

            <div>

                <div class="mb-5 flex items-center gap-3">
                    <span class="h-px w-10 bg-mora-accent"></span>

                    <span class="text-[10px] font-semibold uppercase tracking-[0.3em] text-mora-accent sm:text-xs">
                        Training Sessions
                    </span>
                </div>

                <h2 class="max-w-3xl font-display text-5xl font-semibold uppercase leading-[0.88] tracking-tight sm:text-6xl lg:text-8xl">
                    Train
                    <span class="text-mora-accent">Your Way.</span>
                </h2>

            </div>

            <p class="max-w-md text-sm leading-7 text-mora-muted lg:justify-self-end lg:pb-2">
                Two dedicated daily sessions designed to give every member
                a focused and comfortable training environment.
            </p>

        </div>


        {{-- Sessions --}}
        <div class="mt-14 grid gap-5 md:grid-cols-2">

            @forelse ($trainingSessions as $session)

            <article class="group relative overflow-hidden border border-mora-border bg-mora-card p-7 transition-all duration-500 hover:border-mora-accent/40 sm:p-9 lg:p-11">

                {{-- Decorative number --}}
                <div class="pointer-events-none absolute -right-3 -top-8 font-display text-[9rem] font-bold leading-none text-white/[0.025] transition-all duration-500 group-hover:text-mora-accent/[0.06]">
                    {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                </div>


                {{-- Top --}}
                <div class="relative flex items-start justify-between">

                    <span class="font-display text-sm font-medium tracking-[0.2em] text-white/30">
                        SESSION {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                    </span>

                    <span class="border border-mora-accent/30 px-3 py-1.5 text-[9px] font-semibold uppercase tracking-[0.2em] text-mora-accent">
                        {{ $session->audience }}
                    </span>

                </div>


                {{-- Main --}}
                <div class="relative mt-20">

                    <h3 class="font-display text-4xl font-semibold uppercase leading-[0.9] tracking-tight sm:text-5xl lg:text-6xl">
                        {{ $session->name }}
                    </h3>

                    <p class="mt-5 max-w-md text-sm leading-7 text-mora-muted">
                        {{ $session->description }}
                    </p>

                </div>


                {{-- Schedule --}}
                <div class="relative mt-12 border-t border-white/10 pt-6">

                    <div class="flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">

                        <div>

                            <p class="text-[9px] font-semibold uppercase tracking-[0.25em] text-white/35">
                                Training Hours
                            </p>

                            @if ($session->starts_at && $session->ends_at)

                            <p class="mt-2 font-display text-2xl font-medium tracking-tight sm:text-3xl">
                                {{ \Carbon\Carbon::createFromFormat('H:i:s', $session->starts_at)->format('g:i A') }}

                                <span class="mx-1 text-mora-accent">
                                    —
                                </span>

                                {{ \Carbon\Carbon::createFromFormat('H:i:s', $session->ends_at)->format('g:i A') }}
                            </p>

                            @if (substr($session->ends_at, 0, 5) === '03:00')
                            <p class="mt-1 text-[9px] uppercase tracking-[0.2em] text-white/30">
                                Ends next day
                            </p>
                            @endif

                            @else

                            <p class="mt-2 font-display text-2xl font-medium">
                                Schedule coming soon
                            </p>

                            @endif

                        </div>

                        <div class="flex h-11 w-11 items-center justify-center border border-white/10 text-lg text-mora-accent transition-all duration-300 group-hover:border-mora-accent group-hover:bg-mora-accent group-hover:text-black">
                            →
                        </div>

                    </div>

                </div>

            </article>

            @empty

            <div class="border border-mora-border bg-mora-card p-10 text-center md:col-span-2">
                <p class="text-sm text-mora-muted">
                    Training sessions are currently unavailable.
                </p>
            </div>

            @endforelse

        </div>

    </div>
</section>

@include('home.sections.about')

@include('home.sections.memberships')

@include('home.sections.trainer')

@include('home.sections.gallery')

@endsection
