<section id="gallery" class="scroll-mt-24 border-t border-mora-border bg-mora-bg py-20 md:py-28">
    <div class="mx-auto max-w-7xl px-5 lg:px-8">

        {{-- Header --}}
        <div class="mb-12 flex flex-col gap-6 md:mb-16 md:flex-row md:items-end md:justify-between">
            <div>
                <p class="mb-4 text-xs font-bold uppercase tracking-[0.3em] text-mora-accent">
                    داخل MORA.
                </p>

                <h2 class="font-display text-4xl font-semibold uppercase leading-none tracking-tight text-mora-text sm:text-5xl md:text-6xl">
                    مصمم من أجل
                    <span class="text-mora-accent">الحركة.</span>
                </h2>
            </div>

            <p class="max-w-md text-sm leading-7 text-mora-muted md:text-right">
                ألقِ نظرة على المساحة التي تجتمع فيها روح الانضباط،
                والاستمرارية، والتقدم.
            </p>
        </div>

        {{-- Gallery --}}
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">

            @forelse ($galleryItems as $item)
            <article class="{{ $loop->first ? 'md:row-span-2' : '' }} group relative overflow-hidden rounded-[10px] border border-mora-border bg-mora-card">

                <div class="{{ $loop->first ? 'aspect-[4/5] md:h-full' : 'aspect-[16/10]' }} relative overflow-hidden">

                    <img
                        src="{{ asset('images/' . $item->image) }}"
                        alt="{{ $item->title }}"
                        class="h-full w-full object-cover transition duration-700 group-hover:scale-105"
                        loading="lazy"
                        onerror="this.classList.add('hidden'); this.nextElementSibling.classList.remove('hidden');"
                    >

                    <div class="absolute inset-0 hidden items-center justify-center bg-[radial-gradient(circle_at_center,rgba(200,255,0,0.08),transparent_55%)]">
                        <span class="font-display text-7xl font-bold tracking-tight text-white/[0.05]">MORA</span>
                    </div>

                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/10 to-transparent"></div>

                    <div class="absolute inset-x-0 bottom-0 p-5 sm:p-6">

                        <div class="mb-2 flex items-center justify-between gap-4">
                            <span class="text-[10px] font-bold uppercase tracking-[0.25em] text-mora-accent">
                                {{ $item->category }}
                            </span>

                            <span class="flex h-9 w-9 items-center justify-center rounded-full border border-white/20 text-white/70 transition group-hover:border-mora-accent group-hover:text-mora-accent">
                                ↗
                            </span>
                        </div>

                        <h3 class="font-display text-2xl font-semibold uppercase tracking-wide text-white sm:text-3xl">
                            {{ $item->title }}
                        </h3>

                        @if ($item->description)
                        <p class="mt-2 max-w-lg text-xs leading-6 text-white/60">
                            {{ $item->description }}
                        </p>
                        @endif

                    </div>
                </div>

            </article>
            @empty
                <div class="col-span-full border border-dashed border-mora-border bg-mora-card px-6 py-16 text-center">
                    <p class="text-sm text-mora-muted">
                        معرض الصور غير متاح حاليًا.
                    </p>
                </div>
            @endforelse

        </div>

    </div>
</section>
