@extends('layouts.app')

@section('content')

<section class="min-h-screen bg-mora-bg px-5 pb-20 pt-32">

    <div class="mx-auto max-w-7xl">

        {{-- العنوان --}}
        <div class="mb-12">
            <p class="mb-3 text-sm font-semibold tracking-[0.2em] text-mora-accent">
                عضويتي
            </p>

            <h1 class="font-display text-5xl font-bold uppercase tracking-tight text-mora-text md:text-6xl">
                اشتراكي في MORA
            </h1>

            <p class="mt-4 max-w-2xl text-mora-muted">
                تابع حالة عضويتك وتفاصيل اشتراكك الحالي والاشتراكات السابقة.
            </p>
        </div>


        {{-- الاشتراك الحالي --}}
        @if ($activeSubscription)

        <div class="mb-12 overflow-hidden rounded-xl border border-mora-border bg-mora-card">

            <div class="border-b border-mora-border px-6 py-5 md:px-8">
                <div class="flex flex-col justify-between gap-4 md:flex-row md:items-center">

                    <div>
                        <p class="text-sm text-mora-muted">
                            الاشتراك الحالي
                        </p>

                        <h2 class="mt-1 font-display text-3xl font-bold text-mora-text">
                            {{ $activeSubscription->membershipPlan->name }}
                        </h2>
                    </div>

                    <span class="inline-flex w-fit items-center rounded-full bg-mora-accent/10 px-4 py-2 text-sm font-semibold text-mora-accent">
                        عضوية فعالة
                    </span>

                </div>
            </div>


            <div class="grid gap-px bg-mora-border sm:grid-cols-2 lg:grid-cols-4">

                <div class="bg-mora-card p-6">
                    <p class="text-sm text-mora-muted">
                        قيمة الاشتراك
                    </p>

                    <p class="mt-2 font-display text-3xl font-bold text-mora-text">
                        {{ number_format((float) $activeSubscription->price, 0) }}
                        <span class="text-sm font-normal text-mora-muted">
                            جنيه
                        </span>
                    </p>
                </div>


                <p class="mt-1 text-sm text-mora-muted">

                    @if ($activeSubscription->starts_at && $activeSubscription->ends_at)

                    من
                    {{ $activeSubscription->starts_at->format('d/m/Y') }}
                    إلى
                    {{ $activeSubscription->ends_at->format('d/m/Y') }}

                    @else

                    في انتظار تأكيد الدفع

                    @endif

                </p>


                <div class="bg-mora-card p-6">
                    <p class="text-sm text-mora-muted">
                        المدة المتبقية
                    </p>

                    <p class="mt-2 font-display text-3xl font-bold text-mora-accent">
                        {{ $activeSubscription->ends_at ? max(0, now()->diffInDays($activeSubscription->ends_at, false)) : 0 }}
                        <span class="text-sm font-normal text-mora-muted">
                            يوم
                        </span>
                    </p>
                </div>

            </div>

        </div>

        @else

        {{-- لا يوجد اشتراك --}}
        <div class="mb-12 rounded-xl border border-mora-border bg-mora-card p-8 text-center md:p-12">

            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-mora-accent/10">
                <span class="font-display text-2xl font-bold text-mora-accent">
                    M
                </span>
            </div>

            <h2 class="mt-6 font-display text-3xl font-bold text-mora-text">
                لا يوجد لديك اشتراك فعال
            </h2>

            <p class="mx-auto mt-3 max-w-lg text-mora-muted">
                لم تشترك في إحدى عضويات MORA بعد.
                اختر العضوية المناسبة لك وابدأ رحلتك معنا.
            </p>

            <a href="{{ route('home') }}#memberships" class="mt-8 inline-flex items-center justify-center rounded-md bg-mora-accent px-6 py-3 font-semibold text-mora-bg transition hover:bg-mora-accent-hover">
                استعرض العضويات
            </a>

        </div>

        @endif


        {{-- الاشتراكات السابقة --}}
        <div>

            <div class="mb-6">
                <h2 class="font-display text-3xl font-bold text-mora-text">
                    سجل الاشتراكات
                </h2>

                <p class="mt-2 text-mora-muted">
                    جميع اشتراكاتك السابقة والحالية.
                </p>
            </div>


            <div class="overflow-hidden rounded-xl border border-mora-border bg-mora-card">

                @forelse ($subscriptions as $subscription)

                <div class="flex flex-col gap-5 border-b border-mora-border p-6 last:border-b-0 md:flex-row md:items-center md:justify-between">

                    <div>
                        <h3 class="font-semibold text-mora-text">
                            {{ $subscription->membershipPlan->name }}
                        </h3>

                        <p class="mt-1 text-sm text-mora-muted">
                            @if ($subscription->starts_at && $subscription->ends_at)
                            من
                            {{ $subscription->starts_at->format('d/m/Y') }}
                            إلى
                            {{ $subscription->ends_at->format('d/m/Y') }}
                            @else
                            في انتظار تأكيد الدفع
                            @endif
                        </p>
                    </div>


                    <div class="flex items-center gap-6">

                        <div class="text-left">
                            <p class="text-sm text-mora-muted">
                                القيمة
                            </p>

                            <p class="font-semibold text-mora-text">
                                {{ number_format((float) $subscription->price, 0) }}
                                جنيه
                            </p>
                        </div>


                        @switch($subscription->status->value)

                        @case('active')
                        <span class="rounded-full bg-mora-accent/10 px-3 py-1.5 text-xs font-semibold text-mora-accent">
                            فعال
                        </span>
                        @break

                        @case('expired')
                        <span class="rounded-full bg-white/5 px-3 py-1.5 text-xs font-semibold text-mora-muted">
                            منتهي
                        </span>
                        @break

                        @case('cancelled')
                        <span class="rounded-full bg-red-500/10 px-3 py-1.5 text-xs font-semibold text-red-400">
                            ملغي
                        </span>
                        @break

                        @default
                        <span class="rounded-full bg-yellow-500/10 px-3 py-1.5 text-xs font-semibold text-yellow-400">
                            قيد الانتظار
                        </span>

                        @endswitch

                        @if (
                        $subscription->status->value === 'pending'
                        && $subscription->payment
                        && $subscription->payment->status->value === 'pending'
                        )
                        <a href="{{ route('member.payment.show', $subscription->payment->id) }}" class="rounded-md border border-mora-accent px-4 py-2 text-xs font-semibold text-mora-accent transition hover:bg-mora-accent hover:text-mora-bg">
                            استكمال الدفع
                        </a>
                        @endif

                    </div>

                </div>

                @empty

                <div class="p-8 text-center text-mora-muted">
                    لا توجد اشتراكات مسجلة حتى الآن.
                </div>

                @endforelse

            </div>


            @if ($subscriptions->hasPages())

            <div class="mt-6">
                {{ $subscriptions->links() }}
            </div>

            @endif

        </div>

    </div>

</section>

@endsection
