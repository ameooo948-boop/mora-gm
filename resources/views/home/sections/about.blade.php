<section id="about" class="border-b border-mora-border bg-mora-surface py-24 sm:py-28 lg:py-36">
    <div class="mx-auto max-w-7xl px-5 sm:px-8 lg:px-10">

        <div class="grid gap-14 lg:grid-cols-[0.85fr_1.15fr] lg:items-center lg:gap-24">

            {{-- Image --}}
            <div class="group relative overflow-hidden border border-mora-border bg-mora-card">

                @if ($gymProfile?->image)

                <img src="{{ asset('images/' . $gymProfile->image) }}" alt="{{ $gymProfile->name }}" class="aspect-[4/5] w-full object-cover transition duration-700 group-hover:scale-[1.03]">

                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/10 to-transparent"></div>

                @else

                <div class="flex aspect-[4/5] items-center justify-center bg-[#151515]">
                    <span class="font-display text-8xl font-bold tracking-tight text-white/[0.04]">
                        MORA
                    </span>
                </div>

                @endif

                <div class="absolute bottom-5 left-5 border border-white/10 bg-black/65 px-4 py-3 backdrop-blur-md">

                    <span class="font-display text-2xl font-semibold">
                        {{ $gymProfile?->space_size ?? 150 }}
                    </span>

                    <span class="ml-1 text-xs text-mora-accent">
                        m²
                    </span>

                    <p class="mt-1 text-[8px] uppercase tracking-[0.25em] text-white/45">
                        مساحة التدريب
                    </p>

                </div>

            </div>


            {{-- Content --}}
            <div>

                <div class="mb-5 flex items-center gap-3">

                    <span class="h-px w-10 bg-mora-accent"></span>

                    <span class="text-[10px] font-semibold uppercase tracking-[0.3em] text-mora-accent">
                        {{ $gymProfile?->eyebrow ?? 'ABOUT MORA' }}
                    </span>

                </div>


                <h2 class="max-w-2xl font-display text-5xl font-semibold uppercase leading-[0.88] tracking-tight sm:text-6xl lg:text-8xl">
                    {{ $gymProfile?->about_title ?? 'More Than A Gym.' }}
                </h2>


                <p class="mt-8 max-w-xl text-sm leading-8 text-mora-muted sm:text-base">
                    {{ $gymProfile?->about_description }}
                </p>


                {{-- Mission / Vision --}}
                <div class="mt-10 grid gap-8 border-t border-mora-border pt-8 sm:grid-cols-2">

                    @if ($gymProfile?->mission)

                    <div>
                        <span class="text-[9px] font-semibold uppercase tracking-[0.25em] text-mora-accent">
                            {{ $gymProfile->mission_title ?? 'رسالتنا' }}
                        </span>

                        <p class="mt-3 text-sm leading-7 text-white/60">
                            {{ $gymProfile->mission }}
                        </p>
                    </div>

                    @endif


                    @if ($gymProfile?->vision)

                    <div>
                        <span class="text-[9px] font-semibold uppercase tracking-[0.25em] text-mora-accent">
                            {{ $gymProfile->vision_title ?? 'رؤيتنا' }}
                        </span>

                        <p class="mt-3 text-sm leading-7 text-white/60">
                            {{ $gymProfile->vision }}
                        </p>
                    </div>

                    @endif

                </div>

            </div>

        </div>

    </div>
</section>
