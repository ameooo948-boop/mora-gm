<section id="trainer" class="scroll-mt-24 border-t border-mora-border bg-mora-bg py-20 md:py-28">
    <div class="mx-auto max-w-7xl px-5 lg:px-8">

        {{-- Section Header --}}
        <div class="mb-12 flex flex-col justify-between gap-6 md:mb-16 md:flex-row md:items-end">
            <div class="max-w-2xl">
                <p class="mb-4 text-xs font-bold uppercase tracking-[0.3em] text-mora-accent">
                    TRAIN WITH EXPERIENCE.
                </p>

                <h2 class="font-display text-4xl font-semibold uppercase leading-none tracking-tight text-mora-text sm:text-5xl md:text-6xl">
                    Meet Your
                    <span class="text-mora-accent">Trainers.</span>
                </h2>
            </div>

            <p class="max-w-md text-sm leading-7 text-mora-muted md:text-right">
                Professional guidance, focused training, and the discipline
                you need to keep moving forward.
            </p>
        </div>

        {{-- Trainers --}}
        <div class="grid gap-6 lg:grid-cols-2">

            @forelse ($trainers as $trainer)
            <article class="group relative overflow-hidden rounded-[10px] border border-mora-border bg-mora-card transition duration-300 hover:border-mora-accent/40">

                {{-- Visual --}}
                <div class="relative aspect-[16/10] overflow-hidden bg-mora-surface">

                    @if ($trainer->image)
                    <img src="{{ asset('storage/' . $trainer->image) }}" alt="{{ $trainer->name }}" class="h-full w-full object-cover transition duration-700 group-hover:scale-105">
                    @else
                    <div class="absolute inset-0 flex items-center justify-center">

                        <div class="absolute inset-0 bg-[radial-gradient(circle_at_center,rgba(200,255,0,0.08),transparent_55%)]"></div>

                        <span class="font-display select-none text-[11rem] font-bold leading-none text-white/[0.035] sm:text-[14rem]">
                            {{ strtoupper(substr($trainer->name, 0, 1)) }}
                        </span>

                        <div class="absolute bottom-5 left-5">
                            <span class="text-[10px] font-bold uppercase tracking-[0.35em] text-mora-accent">
                                MORA GYM
                            </span>
                        </div>

                        <div class="absolute right-5 top-5">
                            <span class="font-display text-sm font-semibold uppercase tracking-[0.2em] text-white/30">
                                COACH {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                            </span>
                        </div>
                    </div>
                    @endif

                    {{-- Bottom gradient --}}
                    <div class="absolute inset-x-0 bottom-0 h-1/2 bg-gradient-to-t from-black/80 to-transparent"></div>
                </div>

                {{-- Content --}}
                <div class="p-6 sm:p-8">

                    <div class="mb-6 flex items-start justify-between gap-4">
                        <div>
                            <p class="mb-2 text-[10px] font-bold uppercase tracking-[0.25em] text-mora-accent">
                                {{ $trainer->specialization }}
                            </p>

                            <h3 class="font-display text-3xl font-semibold uppercase tracking-wide text-mora-text sm:text-4xl">
                                {{ $trainer->name }}
                            </h3>
                        </div>

                        <span class="hidden h-10 w-10 shrink-0 items-center justify-center rounded-full border border-mora-border text-mora-muted transition group-hover:border-mora-accent group-hover:text-mora-accent sm:flex">
                            ↗
                        </span>
                    </div>

                    @if ($trainer->bio)
                    <p class="mb-7 max-w-xl text-sm leading-7 text-mora-muted">
                        {{ $trainer->bio }}
                    </p>
                    @endif

                    {{-- Training Sessions --}}
                    @if ($trainer->trainingSessions->isNotEmpty())
                    <div class="border-t border-mora-border pt-5">

                        <p class="mb-3 text-[10px] font-bold uppercase tracking-[0.25em] text-mora-muted">
                            Training Session
                        </p>

                        <div class="space-y-3">
                            @foreach ($trainer->trainingSessions as $session)
                            <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">

                                <div class="flex items-center gap-3">
                                    <span class="h-2 w-2 rounded-full bg-mora-accent"></span>

                                    <span class="text-sm font-semibold text-mora-text">
                                        {{ $session->name }}
                                    </span>
                                </div>

                                <span class="text-xs font-medium uppercase tracking-wide text-mora-muted">
                                    {{ \Carbon\Carbon::createFromFormat('H:i:s', $session->starts_at)->format('g:i A') }}
                                    —
                                    {{ \Carbon\Carbon::createFromFormat('H:i:s', $session->ends_at)->format('g:i A') }}

                                    @if (substr($session->ends_at, 0, 5) === '03:00')
                                    <span class="text-mora-accent">NEXT DAY</span>
                                    @endif
                                </span>

                            </div>
                            @endforeach
                        </div>

                    </div>
                    @endif

                </div>
            </article>
            @empty

            <div class="col-span-full border border-dashed border-mora-border px-6 py-16 text-center">
                <p class="text-sm text-mora-muted">
                    Trainer information will be available soon.
                </p>
            </div>

            @endforelse

        </div>

    </div>
</section>
