<section id="memberships" class="scroll-mt-24 border-b border-mora-border bg-mora-bg py-24 sm:py-28 lg:py-36">
    <div class="mx-auto max-w-7xl px-5 sm:px-8 lg:px-10">

        {{-- Header --}}
        <div class="grid gap-8 lg:grid-cols-[1fr_0.65fr] lg:items-end">

            <div>

                <div class="mb-5 flex items-center gap-3">
                    <span class="h-px w-10 bg-mora-accent"></span>

                    <span class="text-[10px] font-semibold uppercase tracking-[0.3em] text-mora-accent">
                        العضويات
                    </span>
                </div>

                <h2 class="max-w-3xl font-display text-5xl font-semibold uppercase leading-[0.88] tracking-tight sm:text-6xl lg:text-8xl">
                    اختر
                    <span class="text-mora-accent">التزامك.</span>
                </h2>

            </div>

            <p class="max-w-md text-sm leading-7 text-mora-muted lg:justify-self-end lg:pb-2">
                خيارات عضوية بسيطة مصممة حول الاستمرارية،
                والتقدم، والنتائج طويلة المدى.
            </p>

        </div>


        {{-- Plans --}}
        <div class="mt-14 grid gap-5 md:grid-cols-3">

            @forelse ($membershipPlans as $plan)

            <article class="group relative flex flex-col overflow-hidden border
                    {{ $plan->is_featured
                        ? 'border-mora-accent'
                        : 'border-mora-border' }}
                    bg-mora-card p-7 sm:p-8 lg:p-9">

                {{-- Featured --}}
                @if ($plan->is_featured)

                <div class="absolute right-0 top-0 bg-mora-accent px-4 py-2">
                    <span class="text-[8px] font-bold uppercase tracking-[0.2em] text-black">
                        الأكثر طلبًا
                    </span>
                </div>

                @endif


                {{-- Plan Name --}}
                <div class="flex items-start justify-between">

                    <span class="font-display text-5xl font-semibold uppercase leading-none">
                        {{ $plan->name }}
                    </span>

                    <span class="font-display text-4xl font-bold text-white/[0.05]">
                        {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                    </span>

                </div>


                {{-- Description --}}
                @if ($plan->short_description)

                <p class="mt-5 min-h-12 text-sm leading-6 text-mora-muted">
                    {{ $plan->short_description }}
                </p>

                @endif


                {{-- Price --}}
                <div class="mt-8 border-y border-white/10 py-6">

                    @if ($plan->price !== null)

                    <div class="flex items-end gap-2">

                        <span class="font-display text-5xl font-semibold">
                            {{ number_format((float) $plan->price, 0) }}
                        </span>

                        <span class="mb-2 text-xs uppercase tracking-[0.15em] text-mora-muted">
                            EGP
                        </span>

                    </div>

                    @else

                    <p class="font-display text-3xl font-medium uppercase">
                        تواصل معنا
                    </p>

                    <p class="mt-1 text-[9px] uppercase tracking-[0.2em] text-white/35">
                        الأسعار متاحة داخل الجيم
                    </p>

                    @endif

                </div>


                {{-- Features --}}
                <ul class="mt-7 flex-1 space-y-4">

                    @foreach ($plan->features ?? [] as $feature)

                    <li class="flex items-start gap-3 text-sm text-white/65">

                        <span class="mt-0.5 text-mora-accent">
                            ✓
                        </span>

                        <span>
                            {{ $feature }}
                        </span>

                    </li>

                    @endforeach

                </ul>


                {{-- CTA --}}
                @auth
                    @if (auth()->user()->isMember())
                        <form
                            method="POST"
                            action="{{ route('member.membership.subscribe', $plan) }}"
                            class="mt-9"
                        >
                            @csrf

                            <button
                                type="submit"
                                class="inline-flex w-full items-center justify-center gap-3 border
                                    {{ $plan->is_featured
                                        ? 'border-mora-accent bg-mora-accent text-black hover:bg-mora-accent-hover'
                                        : 'border-white/15 text-white hover:border-white/35 hover:bg-white/5' }}
                                    px-6 py-4 text-xs font-bold tracking-[0.15em] transition-all duration-300"
                            >
                                اشترك الآن
                                <span aria-hidden="true">→</span>
                            </button>
                        </form>
                    @elseif (auth()->user()->isAdmin())
                        <a
                            href="{{ route('admin.dashboard') }}"
                            class="mt-9 inline-flex w-full items-center justify-center gap-3 border border-white/15 px-6 py-4 text-xs font-bold tracking-[0.15em] text-white transition-all duration-300 hover:border-white/35 hover:bg-white/5"
                        >
                            لوحة الإدارة
                            <span aria-hidden="true">→</span>
                        </a>
                    @endif
                @else
                    <a
                        href="{{ route('login') }}"
                        class="mt-9 inline-flex w-full items-center justify-center gap-3 border
                            {{ $plan->is_featured
                                ? 'border-mora-accent bg-mora-accent text-black hover:bg-mora-accent-hover'
                                : 'border-white/15 text-white hover:border-white/35 hover:bg-white/5' }}
                            px-6 py-4 text-xs font-bold tracking-[0.15em] transition-all duration-300"
                    >
                        تسجيل الدخول للاشتراك
                        <span aria-hidden="true">→</span>
                    </a>
                @endauth

            </article>

            @empty

            <div class="border border-mora-border bg-mora-card p-10 text-center md:col-span-3">
                <p class="text-sm text-mora-muted">
                    خطط العضوية غير متاحة حاليًا.
                </p>
            </div>

            @endforelse

        </div>

    </div>
</section>
