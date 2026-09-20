<section id="contact" class="scroll-mt-24 border-t border-mora-border bg-mora-bg py-20 md:py-28">
    <div class="mx-auto max-w-7xl px-5 lg:px-8">

        {{-- Header --}}
        <div class="mb-12 md:mb-16">
            <p class="mb-4 text-xs font-bold uppercase tracking-[0.3em] text-mora-accent">
                تواصل معنا.
            </p>

            <h2 class="font-display text-4xl font-semibold uppercase leading-none tracking-tight text-mora-text sm:text-5xl md:text-6xl">
                اعرف طريقك
                <span class="text-mora-accent">إلى MORA.</span>
            </h2>
        </div>

        <div class="grid gap-6 lg:grid-cols-[1.15fr_0.85fr]">

            {{-- Main Contact Card --}}
            <div class="rounded-[10px] border border-mora-border bg-mora-card p-6 sm:p-8 md:p-10">

                <div class="mb-10">
                    <span class="font-display text-5xl font-semibold uppercase text-mora-text">
                        MORA
                    </span>

                    <p class="mt-4 max-w-lg text-sm leading-7 text-mora-muted">
                        مساحة تدريبية مركزة تقوم على الانضباط،
                        والاستمرارية، والتقدم الحقيقي.
                    </p>
                </div>

                <div class="grid gap-4 sm:grid-cols-2">

                    @if ($gymProfile?->phone)
                    <a href="tel:{{ $gymProfile->phone }}" class="group rounded-[6px] border border-mora-border bg-mora-surface p-5 transition hover:border-mora-accent/50">
                        <span class="mb-3 block text-[10px] font-bold uppercase tracking-[0.25em] text-mora-muted">
                            الهاتف
                        </span>

                        <span class="text-sm font-semibold text-mora-text transition group-hover:text-mora-accent">
                            {{ $gymProfile->phone }}
                        </span>
                    </a>
                    @endif

                    @if ($gymProfile?->whatsapp)
                    <a href="https://wa.me/{{ preg_replace('/\D+/', '', $gymProfile->whatsapp) }}" target="_blank" rel="noopener noreferrer" class="group rounded-[6px] border border-mora-border bg-mora-surface p-5 transition hover:border-mora-accent/50">
                        <span class="mb-3 block text-[10px] font-bold uppercase tracking-[0.25em] text-mora-muted">
                            واتساب
                        </span>

                        <span class="text-sm font-semibold text-mora-text transition group-hover:text-mora-accent">
                            {{ $gymProfile->whatsapp }}
                        </span>
                    </a>
                    @endif

                    @if ($gymProfile?->email)
                    <a href="mailto:{{ $gymProfile->email }}" class="group rounded-[6px] border border-mora-border bg-mora-surface p-5 transition hover:border-mora-accent/50">
                        <span class="mb-3 block text-[10px] font-bold uppercase tracking-[0.25em] text-mora-muted">
                            البريد الإلكتروني
                        </span>

                        <span class="break-all text-sm font-semibold text-mora-text transition group-hover:text-mora-accent">
                            {{ $gymProfile->email }}
                        </span>
                    </a>
                    @endif

                    @if ($gymProfile?->address)
                    <div class="rounded-[6px] border border-mora-border bg-mora-surface p-5">
                        <span class="mb-3 block text-[10px] font-bold uppercase tracking-[0.25em] text-mora-muted">
                            الموقع
                        </span>

                        <span class="text-sm font-semibold leading-6 text-mora-text">
                            {{ $gymProfile->address }}
                        </span>
                    </div>
                    @endif

                </div>

                @if ($gymProfile?->instagram_url)
                <div class="mt-4">
                    <a href="{{ $gymProfile->instagram_url }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-3 rounded-[6px] border border-mora-border px-5 py-3 text-xs font-bold uppercase tracking-wide text-mora-text transition hover:border-mora-accent hover:text-mora-accent">
                        تابع MORA على إنستجرام
                        <span>↗</span>
                    </a>
                </div>
                @endif

            </div>

            {{-- Sessions Card --}}
            <div class="rounded-[10px] border border-mora-border bg-mora-card p-6 sm:p-8 md:p-10">

                <p class="mb-2 text-[10px] font-bold uppercase tracking-[0.25em] text-mora-accent">
                    مفتوح يوميًا
                </p>

                <h3 class="font-display text-3xl font-semibold uppercase text-mora-text">
                    مواعيد التدريب
                </h3>

                <div class="mt-8 divide-y divide-mora-border">

                    @forelse ($trainingSessions as $session)
                    <div class="py-5 first:pt-0 last:pb-0">

                        <div class="mb-2 flex items-center justify-between gap-4">
                            <span class="font-display text-xl font-semibold uppercase text-mora-text">
                                {{ $session->name }}
                            </span>

                            <span class="h-2 w-2 shrink-0 rounded-full bg-mora-accent"></span>
                        </div>

                        <p class="text-xs uppercase tracking-wide text-mora-muted">
                            {{ $session->audience === 'Women' ? 'السيدات' : 'الرجال' }}
                        </p>

                        <p class="mt-2 text-sm font-semibold text-mora-text">
                            {{ $session->formatted_start_time }} —
                            {{ $session->formatted_end_time }}

                            @if ($session->ends_next_day)
                            <span class="ml-1 text-xs font-bold text-mora-accent">
                                اليوم التالي
                            </span>
                            @endif
                        </p>

                    </div>
                    @empty
                    <p class="py-5 text-sm text-mora-muted">مواعيد التدريب غير متاحة حاليًا.</p>
                    @endforelse

                </div>

            </div>

        </div>

    </div>
</section>
