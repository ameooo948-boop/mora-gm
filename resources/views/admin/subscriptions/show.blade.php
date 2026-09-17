@extends('layouts.app')

@section('content')

<section class="min-h-screen bg-mora-bg py-24">
    <div class="mx-auto max-w-5xl px-5">

        <div class="mb-10">

            <a href="{{ route('admin.subscriptions.index') }}" class="text-xs font-semibold text-mora-accent hover:underline">
                ← العودة إلى الاشتراكات
            </a>

            <p class="mt-6 text-xs uppercase tracking-[0.2em] text-mora-muted">
                تفاصيل الاشتراك
            </p>

            <h1 class="mt-2 font-display text-4xl font-bold text-mora-text">
                {{ $subscription->membershipPlan->name }}
            </h1>

        </div>

        {{-- Status --}}
        <div class="mb-6 border border-mora-border bg-mora-card p-6">

            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                <div>
                    <p class="text-xs text-mora-muted">
                        حالة الاشتراك
                    </p>

                    @switch($subscription->status->value)

                    @case('active')
                    <p class="mt-2 font-semibold text-mora-accent">
                        عضوية فعالة
                    </p>
                    @break

                    @case('pending')
                    <p class="mt-2 font-semibold text-yellow-400">
                        قيد الانتظار
                    </p>
                    @break

                    @case('expired')
                    <p class="mt-2 font-semibold text-mora-muted">
                        منتهية
                    </p>
                    @break

                    @case('cancelled')
                    <p class="mt-2 font-semibold text-red-400">
                        ملغاة
                    </p>
                    @break

                    @endswitch
                </div>

                <div>
                    <p class="text-xs text-mora-muted">
                        قيمة الاشتراك
                    </p>

                    <p class="mt-1 font-display text-2xl text-mora-text">
                        {{ number_format((float) $subscription->price, 0) }}
                        جنيه
                    </p>
                </div>

            </div>

        </div>

        {{-- Member --}}
        <div class="mb-6 border border-mora-border bg-mora-card p-6">

            <p class="text-xs uppercase tracking-[0.2em] text-mora-muted">
                بيانات العضو
            </p>

            <div class="mt-6 grid gap-5 md:grid-cols-3">

                <div>
                    <p class="text-xs text-mora-muted">
                        الاسم
                    </p>

                    <p class="mt-2 text-sm text-mora-text">
                        {{ $subscription->user->name }}
                    </p>
                </div>

                <div>
                    <p class="text-xs text-mora-muted">
                        البريد الإلكتروني
                    </p>

                    <p class="mt-2 text-sm text-mora-text">
                        {{ $subscription->user->email }}
                    </p>
                </div>

                <div>
                    <p class="text-xs text-mora-muted">
                        الهاتف
                    </p>

                    <p class="mt-2 text-sm text-mora-text">
                        {{ $subscription->user->phone ?: 'غير مسجل' }}
                    </p>
                </div>

            </div>

        </div>

        {{-- Subscription --}}
        <div class="mb-6 border border-mora-border bg-mora-card p-6">

            <p class="text-xs uppercase tracking-[0.2em] text-mora-muted">
                تفاصيل العضوية
            </p>

            <div class="mt-6 grid gap-5 md:grid-cols-3">

                <div>
                    <p class="text-xs text-mora-muted">
                        الباقة
                    </p>

                    <p class="mt-2 text-sm text-mora-text">
                        {{ $subscription->membershipPlan->name }}
                    </p>
                </div>

                <div>
                    <p class="text-xs text-mora-muted">
                        تاريخ البداية
                    </p>

                    <p class="mt-2 text-sm text-mora-text">
                        {{ $subscription->starts_at?->format('d/m/Y') ?? 'لم تبدأ' }}
                    </p>
                </div>

                <div>
                    <p class="text-xs text-mora-muted">
                        تاريخ النهاية
                    </p>

                    <p class="mt-2 text-sm text-mora-text">
                        {{ $subscription->ends_at?->format('d/m/Y') ?? 'لم تحدد' }}
                    </p>
                </div>

            </div>

        </div>

        {{-- Payment --}}
        <div class="border border-mora-border bg-mora-card p-6">

            <p class="text-xs uppercase tracking-[0.2em] text-mora-muted">
                عملية الدفع
            </p>

            @if ($subscription->payment)

            <div class="mt-6 grid gap-5 md:grid-cols-3">

                <div>
                    <p class="text-xs text-mora-muted">
                        طريقة الدفع
                    </p>

                    <p class="mt-2 text-sm text-mora-text">
                        Vodafone Cash
                    </p>
                </div>

                <div>
                    <p class="text-xs text-mora-muted">
                        رقم العملية
                    </p>

                    <p class="mt-2 text-sm text-mora-text">
                        {{ $subscription->payment->transaction_reference ?: 'لم يتم الإرسال' }}
                    </p>
                </div>

                <div>
                    <p class="text-xs text-mora-muted">
                        حالة الدفع
                    </p>

                    @switch($subscription->payment->status->value)

                    @case('paid')
                    <p class="mt-2 text-sm text-mora-accent">
                        مكتملة
                    </p>
                    @break

                    @case('rejected')
                    <p class="mt-2 text-sm text-red-400">
                        مرفوضة
                    </p>
                    @break

                    @default
                    <p class="mt-2 text-sm text-yellow-400">
                        قيد المراجعة
                    </p>

                    @endswitch
                </div>

            </div>

            @else

            <p class="mt-5 text-sm text-mora-muted">
                لا توجد عملية دفع مرتبطة بهذا الاشتراك.
            </p>

            @endif

        </div>

    </div>
</section>

@endsection
