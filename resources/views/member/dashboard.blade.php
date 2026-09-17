@extends('layouts.app')

@section('content')

<section class="min-h-screen bg-mora-bg py-24">
    <div class="mx-auto max-w-7xl px-5">

        <div class="mb-12">
            <p class="mb-3 text-xs font-semibold uppercase tracking-[0.25em] text-mora-accent">
                MORA GYM
            </p>

            <h1 class="font-display text-4xl font-bold text-mora-text md:text-5xl">
                أهلًا، {{ $user->name }}
            </h1>

            <p class="mt-4 text-sm text-mora-muted">
                تابع عضويتك وحضورك وعمليات الدفع من لوحة التحكم الخاصة بك.
            </p>
        </div>

        {{-- Membership --}}
        <div class="mb-8 border border-mora-border bg-mora-card p-6 md:p-8">

            <div class="flex flex-col gap-6 md:flex-row md:items-center md:justify-between">

                <div>
                    <p class="text-xs uppercase tracking-[0.2em] text-mora-muted">
                        العضوية الحالية
                    </p>

                    @if ($activeSubscription)

                    <h2 class="mt-2 font-display text-3xl font-semibold text-mora-text">
                        {{ $activeSubscription->membershipPlan->name }}
                    </h2>

                    <p class="mt-2 text-sm text-mora-muted">
                        تنتهي في
                        {{ $activeSubscription->ends_at?->format('d/m/Y') ?? '—' }}
                    </p>

                    @else

                    <h2 class="mt-2 font-display text-2xl font-semibold text-mora-text">
                        لا توجد عضوية فعالة
                    </h2>

                    <p class="mt-2 text-sm text-mora-muted">
                        اختر الباقة المناسبة لك وابدأ رحلتك مع MORA.
                    </p>

                    @endif
                </div>

                <div>
                    @if ($activeSubscription)

                    <span class="inline-flex border border-mora-accent/30 px-4 py-2 text-sm font-semibold text-mora-accent">
                        عضوية فعالة
                    </span>

                    @else

                    <a href="{{ route('home') }}#memberships" class="inline-flex rounded-md bg-mora-accent px-5 py-3 text-sm font-bold text-mora-bg transition hover:bg-mora-accent-hover">
                        عرض الباقات
                    </a>

                    @endif
                </div>

            </div>

            @if ($activeSubscription)

            <div class="mt-8 grid gap-4 border-t border-mora-border pt-8 sm:grid-cols-3">

                <div>
                    <p class="text-xs text-mora-muted">
                        سعر الباقة
                    </p>

                    <p class="mt-2 font-display text-2xl text-mora-text">
                        {{ number_format((float) $activeSubscription->price, 0) }}
                        <span class="text-sm text-mora-muted">جنيه</span>
                    </p>
                </div>

                <div>
                    <p class="text-xs text-mora-muted">
                        بداية العضوية
                    </p>

                    <p class="mt-2 text-sm text-mora-text">
                        {{ $activeSubscription->starts_at?->format('d/m/Y') ?? '—' }}
                    </p>
                </div>

                <div>
                    <p class="text-xs text-mora-muted">
                        الأيام المتبقية
                    </p>

                    <p class="mt-2 font-display text-2xl text-mora-accent">
                        {{ $activeSubscription->ends_at
                                ? max(0, now()->diffInDays($activeSubscription->ends_at, false))
                                : 0
                            }}
                    </p>
                </div>

            </div>

            @endif

        </div>

        {{-- Quick Actions --}}
        <div class="mb-12 grid gap-4 sm:grid-cols-3">

            <a href="{{ route('member.subscription') }}" class="border border-mora-border bg-mora-card p-6 transition hover:border-mora-accent">
                <p class="text-xs text-mora-muted">
                    الحساب
                </p>

                <h3 class="mt-2 font-display text-xl font-semibold text-mora-text">
                    عضويتي
                </h3>

                <p class="mt-2 text-sm text-mora-muted">
                    عرض تفاصيل العضوية والاشتراكات السابقة.
                </p>
            </a>

            <a href="{{ route('member.attendance') }}" class="border border-mora-border bg-mora-card p-6 transition hover:border-mora-accent">
                <p class="text-xs text-mora-muted">
                    المتابعة
                </p>

                <h3 class="mt-2 font-display text-xl font-semibold text-mora-text">
                    الحضور
                </h3>

                <p class="mt-2 text-sm text-mora-muted">
                    تسجيل الحضور والانصراف ومراجعة السجل.
                </p>
            </a>

            <a href="{{ route('home') }}#memberships" class="border border-mora-border bg-mora-card p-6 transition hover:border-mora-accent">
                <p class="text-xs text-mora-muted">
                    العضويات
                </p>

                <h3 class="mt-2 font-display text-xl font-semibold text-mora-text">
                    الباقات
                </h3>

                <p class="mt-2 text-sm text-mora-muted">
                    تعرف على باقات عضوية MORA المتاحة.
                </p>
            </a>

        </div>

        {{-- Recent Attendance --}}
        <div class="mb-12">

            <div class="mb-6 flex items-end justify-between">
                <div>
                    <p class="text-xs uppercase tracking-[0.2em] text-mora-muted">
                        آخر الزيارات
                    </p>

                    <h2 class="mt-2 font-display text-2xl font-semibold text-mora-text">
                        آخر الحضور
                    </h2>
                </div>

                <a href="{{ route('member.attendance') }}" class="text-xs font-semibold text-mora-accent hover:underline">
                    عرض الكل
                </a>
            </div>

            <div class="border border-mora-border bg-mora-card">

                @forelse ($recentAttendances as $attendance)

                <div class="flex flex-col gap-3 border-b border-mora-border p-5 last:border-b-0 sm:flex-row sm:items-center sm:justify-between">

                    <div>
                        <p class="font-semibold text-mora-text">
                            {{ $attendance->trainingSession->name }}
                        </p>

                        <p class="mt-1 text-xs text-mora-muted">
                            {{ $attendance->attendance_date->format('d/m/Y') }}
                        </p>
                    </div>

                    <div class="text-xs text-mora-muted">
                        حضور:
                        <span class="text-mora-text">
                            {{ $attendance->checked_in_at?->format('h:i A') ?? '—' }}
                        </span>

                        <span class="mx-2">•</span>

                        انصراف:
                        <span class="text-mora-text">
                            {{ $attendance->checked_out_at?->format('h:i A') ?? 'لم يسجل' }}
                        </span>
                    </div>

                </div>

                @empty

                <div class="p-8 text-center text-sm text-mora-muted">
                    لا توجد سجلات حضور حتى الآن.
                </div>

                @endforelse

            </div>

        </div>

        {{-- Recent Payments --}}
        <div>

            <div class="mb-6 flex items-end justify-between">
                <div>
                    <p class="text-xs uppercase tracking-[0.2em] text-mora-muted">
                        العمليات المالية
                    </p>

                    <h2 class="mt-2 font-display text-2xl font-semibold text-mora-text">
                        آخر عمليات الدفع
                    </h2>
                </div>
            </div>

            <div class="border border-mora-border bg-mora-card">

                @forelse ($recentPayments as $payment)

                <div class="flex flex-col gap-3 border-b border-mora-border p-5 last:border-b-0 sm:flex-row sm:items-center sm:justify-between">

                    <div>
                        <p class="font-semibold text-mora-text">
                            {{ $payment->subscription->membershipPlan->name }}
                        </p>

                        <p class="mt-1 text-xs text-mora-muted">
                            {{ $payment->created_at->format('d/m/Y') }}
                        </p>
                    </div>

                    <div class="flex items-center gap-4">

                        <span class="font-display text-lg text-mora-text">
                            {{ number_format((float) $payment->amount, 0) }}
                            جنيه
                        </span>

                        @switch($payment->status->value)

                        @case('paid')
                        <span class="border border-mora-accent/30 px-3 py-1 text-xs text-mora-accent">
                            مكتملة
                        </span>
                        @break

                        @case('rejected')
                        <span class="border border-red-500/30 px-3 py-1 text-xs text-red-400">
                            مرفوضة
                        </span>
                        @break

                        @default
                        <span class="border border-yellow-500/30 px-3 py-1 text-xs text-yellow-400">
                            قيد المراجعة
                        </span>

                        @endswitch

                    </div>

                </div>

                @empty

                <div class="p-8 text-center text-sm text-mora-muted">
                    لا توجد عمليات دفع حتى الآن.
                </div>

                @endforelse

            </div>

        </div>

    </div>
</section>

@endsection
