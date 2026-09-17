@extends('layouts.app')

@section('content')

<section class="min-h-screen bg-mora-bg py-24">
    <div class="mx-auto max-w-7xl px-5">

        <div class="mb-10">
            <a href="{{ route('admin.members.index') }}" class="text-xs font-semibold text-mora-accent hover:underline">
                ← العودة إلى الأعضاء
            </a>

            <div class="mt-6">
                <p class="text-xs uppercase tracking-[0.2em] text-mora-muted">
                    ملف العضو
                </p>

                <h1 class="mt-2 font-display text-4xl font-bold text-mora-text">
                    {{ $member->name }}
                </h1>
            </div>
        </div>

        {{-- Basic Information --}}
        <div class="mb-8 grid gap-4 md:grid-cols-3">

            <div class="border border-mora-border bg-mora-card p-6">
                <p class="text-xs text-mora-muted">
                    البريد الإلكتروني
                </p>

                <p class="mt-2 text-sm text-mora-text">
                    {{ $member->email }}
                </p>
            </div>

            <div class="border border-mora-border bg-mora-card p-6">
                <p class="text-xs text-mora-muted">
                    الهاتف
                </p>

                <p class="mt-2 text-sm text-mora-text">
                    {{ $member->phone ?: 'غير مسجل' }}
                </p>
            </div>

            <div class="border border-mora-border bg-mora-card p-6">
                <p class="text-xs text-mora-muted">
                    النوع
                </p>

                <p class="mt-2 text-sm text-mora-text">
                    {{ $member->gender?->label() ?? 'غير محدد' }}
                </p>
            </div>

        </div>

        {{-- Active Subscription --}}
        <div class="mb-8 border border-mora-border bg-mora-card p-6">

            <p class="text-xs uppercase tracking-[0.2em] text-mora-muted">
                العضوية الحالية
            </p>

            @if ($member->activeSubscription)

            <div class="mt-5 grid gap-5 md:grid-cols-3">

                <div>
                    <p class="text-xs text-mora-muted">
                        الباقة
                    </p>

                    <p class="mt-2 font-display text-xl text-mora-text">
                        {{ $member->activeSubscription->membershipPlan->name }}
                    </p>
                </div>

                <div>
                    <p class="text-xs text-mora-muted">
                        البداية
                    </p>

                    <p class="mt-2 text-sm text-mora-text">
                        {{ $member->activeSubscription->starts_at?->format('d/m/Y') ?? '—' }}
                    </p>
                </div>

                <div>
                    <p class="text-xs text-mora-muted">
                        النهاية
                    </p>

                    <p class="mt-2 text-sm text-mora-text">
                        {{ $member->activeSubscription->ends_at?->format('d/m/Y') ?? '—' }}
                    </p>
                </div>

            </div>

            @else

            <p class="mt-5 text-sm text-mora-muted">
                لا توجد عضوية فعالة حاليًا.
            </p>

            @endif

        </div>

        {{-- Subscription History --}}
        <div class="mb-8 border border-mora-border bg-mora-card p-6">

            <div class="mb-6">
                <p class="text-xs uppercase tracking-[0.2em] text-mora-muted">
                    سجل الاشتراكات
                </p>
            </div>

            <div class="space-y-4">

                @forelse ($member->subscriptions as $subscription)

                <div class="border border-mora-border p-5">

                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

                        <div>
                            <p class="font-semibold text-mora-text">
                                {{ $subscription->membershipPlan->name }}
                            </p>

                            <p class="mt-1 text-xs text-mora-muted">
                                {{ number_format((float) $subscription->price, 0) }}
                                جنيه
                            </p>
                        </div>

                        @switch($subscription->status->value)

                        @case('active')
                        <span class="text-xs text-mora-accent">
                            فعالة
                        </span>
                        @break

                        @case('expired')
                        <span class="text-xs text-mora-muted">
                            منتهية
                        </span>
                        @break

                        @case('cancelled')
                        <span class="text-xs text-red-400">
                            ملغاة
                        </span>
                        @break

                        @default
                        <span class="text-xs text-yellow-400">
                            قيد الانتظار
                        </span>

                        @endswitch

                    </div>

                </div>

                @empty

                <p class="text-sm text-mora-muted">
                    لا توجد اشتراكات مسجلة.
                </p>

                @endforelse

            </div>

        </div>

        {{-- Attendance --}}
        <div class="border border-mora-border bg-mora-card p-6">

            <div class="mb-6">
                <p class="text-xs uppercase tracking-[0.2em] text-mora-muted">
                    سجل الحضور
                </p>
            </div>

            <div class="space-y-4">

                @forelse ($member->attendances->take(10) as $attendance)

                <div class="flex flex-col gap-3 border-b border-mora-border pb-4 last:border-b-0 last:pb-0 sm:flex-row sm:items-center sm:justify-between">

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

                <p class="text-sm text-mora-muted">
                    لا توجد سجلات حضور.
                </p>

                @endforelse

            </div>

        </div>

    </div>
</section>

@endsection
