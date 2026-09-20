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

            <div class="space-y-5">

                @forelse ($member->subscriptions as $subscription)

                <div class="border border-mora-border p-5">

                    {{-- Subscription Header --}}
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

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
                        <span class="text-xs font-semibold text-mora-accent">
                            فعالة
                        </span>
                        @break

                        @case('expired')
                        <span class="text-xs font-semibold text-mora-muted">
                            منتهية
                        </span>
                        @break

                        @case('cancelled')
                        <span class="text-xs font-semibold text-red-400">
                            ملغاة
                        </span>
                        @break

                        @default
                        <span class="text-xs font-semibold text-yellow-400">
                            قيد الانتظار
                        </span>

                        @endswitch

                    </div>

                    {{-- Subscription Information --}}
                    <div class="mt-5 grid gap-4 border-t border-mora-border pt-5 sm:grid-cols-2 lg:grid-cols-4">

                        <div>
                            <p class="text-xs text-mora-muted">
                                مدة الباقة
                            </p>

                            <p class="mt-1 text-sm text-mora-text">
                                {{ $subscription->duration_days ?? $subscription->membershipPlan->duration_days }}
                                يوم
                            </p>
                        </div>

                        <div>
                            <p class="text-xs text-mora-muted">
                                تاريخ الطلب
                            </p>

                            <p class="mt-1 text-sm text-mora-text">
                                {{ $subscription->created_at?->format('d/m/Y h:i A') ?? '—' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-xs text-mora-muted">
                                بداية العضوية
                            </p>

                            <p class="mt-1 text-sm text-mora-text">
                                {{ $subscription->starts_at?->format('d/m/Y h:i A') ?? '—' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-xs text-mora-muted">
                                نهاية العضوية
                            </p>

                            <p class="mt-1 text-sm text-mora-text">
                                {{ $subscription->ends_at?->format('d/m/Y h:i A') ?? '—' }}
                            </p>
                        </div>

                    </div>

                    {{-- Payment Information --}}
                    @if ($subscription->payment)

                    <div class="mt-5 border-t border-mora-border pt-5">

                        <p class="text-xs uppercase tracking-[0.2em] text-mora-muted">
                            بيانات الدفع
                        </p>

                        <div class="mt-4 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">

                            <div>
                                <p class="text-xs text-mora-muted">
                                    طريقة الدفع
                                </p>

                                <p class="mt-1 text-sm text-mora-text">
                                    فودافون كاش
                                </p>
                            </div>

                            <div>
                                <p class="text-xs text-mora-muted">
                                    المبلغ
                                </p>

                                <p class="mt-1 text-sm text-mora-text">
                                    {{ number_format((float) $subscription->payment->amount, 0) }}
                                    جنيه
                                </p>
                            </div>

                            <div>
                                <p class="text-xs text-mora-muted">
                                    حالة الدفع
                                </p>

                                @switch($subscription->payment->status->value)

                                @case('paid')
                                <p class="mt-1 text-sm text-mora-accent">
                                    تم الدفع
                                </p>
                                @break

                                @case('rejected')
                                <p class="mt-1 text-sm text-red-400">
                                    مرفوض
                                </p>
                                @break

                                @default
                                <p class="mt-1 text-sm text-yellow-400">
                                    قيد المراجعة
                                </p>

                                @endswitch
                            </div>

                            <div>
                                <p class="text-xs text-mora-muted">
                                    تاريخ الدفع
                                </p>

                                <p class="mt-1 text-sm text-mora-text">
                                    {{ $subscription->payment->paid_at?->format('d/m/Y h:i A') ?? '—' }}
                                </p>
                            </div>

                        </div>

                        @if ($subscription->payment->transaction_reference)

                        <div class="mt-4">
                            <p class="text-xs text-mora-muted">
                                رقم العملية
                            </p>

                            <p class="mt-1 break-all text-sm text-mora-text">
                                {{ $subscription->payment->transaction_reference }}
                            </p>
                        </div>

                        @endif

                        @if ($subscription->payment->notes)

                        <div class="mt-4 border border-mora-border bg-mora-surface p-4">

                            <p class="text-xs text-mora-muted">
                                ملاحظات الإدارة
                            </p>

                            <p class="mt-2 text-sm leading-7 text-mora-text">
                                {{ $subscription->payment->notes }}
                            </p>

                        </div>

                        @endif

                    </div>

                    @endif

                </div>

                @empty

                <p class="text-sm text-mora-muted">
                    لا توجد اشتراكات مسجلة.
                </p>

                @endforelse

            </div>

        </div>

        {{-- Payment History --}}
        <div class="mb-8 border border-mora-border bg-mora-card p-6">

            <div class="mb-6">
                <p class="text-xs uppercase tracking-[0.2em] text-mora-muted">
                    سجل المدفوعات
                </p>
            </div>

            <div class="space-y-4">

                @forelse ($member->payments as $payment)

                <div class="border border-mora-border p-5">

                    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

                        <div>
                            <p class="font-semibold text-mora-text">
                                {{ $payment->subscription?->membershipPlan?->name ?? 'باقة غير محددة' }}
                            </p>

                            <p class="mt-1 text-xs text-mora-muted">
                                المبلغ:
                                {{ number_format((float) $payment->amount, 0) }}
                                جنيه
                            </p>

                            @if ($payment->transaction_reference)
                            <p class="mt-1 text-xs text-mora-muted">
                                رقم العملية:
                                <span class="text-mora-text">
                                    {{ $payment->transaction_reference }}
                                </span>
                            </p>
                            @endif
                        </div>

                        <div class="flex flex-col gap-2 text-xs lg:items-end">

                            @switch($payment->status->value)

                            @case('paid')
                            <span class="text-mora-accent">
                                تم الدفع
                            </span>
                            @break

                            @case('rejected')
                            <span class="text-red-400">
                                مرفوض
                            </span>
                            @break

                            @default
                            <span class="text-yellow-400">
                                قيد المراجعة
                            </span>

                            @endswitch

                            <span class="text-mora-muted">
                                {{ $payment->paid_at?->format('d/m/Y h:i A') ?? 'لم يتم الدفع بعد' }}
                            </span>

                        </div>

                    </div>

                    @if ($payment->notes)
                    <div class="mt-4 border-t border-mora-border pt-4">
                        <p class="text-xs text-mora-muted">
                            ملاحظات الإدارة
                        </p>

                        <p class="mt-1 text-sm leading-6 text-mora-text">
                            {{ $payment->notes }}
                        </p>
                    </div>
                    @endif

                </div>

                @empty

                <p class="text-sm text-mora-muted">
                    لا توجد مدفوعات مسجلة.
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

        <div class="mt-8 border border-mora-border bg-mora-card p-6">
            <h2 class="font-display text-2xl font-semibold">
                تعديل بيانات العضو
            </h2>

            <form method="POST" action="{{ route('admin.members.update', $member->id) }}" class="mt-6 space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label class="mb-2 block text-sm font-medium">
                        الاسم
                    </label>

                    <input type="text" name="name" value="{{ old('name', $member->name) }}" class="w-full rounded-md border border-mora-border bg-mora-surface px-4 py-3 text-sm outline-none focus:border-mora-accent" required>

                    @error('name')
                    <p class="mt-2 text-xs text-red-400">
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium">
                        البريد الإلكتروني
                    </label>

                    <input type="email" name="email" value="{{ old('email', $member->email) }}" class="w-full rounded-md border border-mora-border bg-mora-surface px-4 py-3 text-sm outline-none focus:border-mora-accent" required>

                    @error('email')
                    <p class="mt-2 text-xs text-red-400">
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium">
                        رقم الهاتف
                    </label>

                    <input type="text" name="phone" value="{{ old('phone', $member->phone) }}" class="w-full rounded-md border border-mora-border bg-mora-surface px-4 py-3 text-sm outline-none focus:border-mora-accent">

                    @error('phone')
                    <p class="mt-2 text-xs text-red-400">
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium">
                        النوع
                    </label>

                    <select name="gender" class="w-full rounded-md border border-mora-border bg-mora-surface px-4 py-3 text-sm outline-none focus:border-mora-accent" required>
                        <option value="male" @selected(old('gender', $member->gender?->value) === 'male')>
                            ذكر
                        </option>

                        <option value="female" @selected(old('gender', $member->gender?->value) === 'female')>
                            أنثى
                        </option>
                    </select>

                    @error('gender')
                    <p class="mt-2 text-xs text-red-400">
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                <button type="submit" class="rounded-md bg-mora-accent px-6 py-3 text-sm font-bold text-mora-bg transition hover:bg-mora-accent-hover">
                    حفظ التعديلات
                </button>
            </form>
        </div>

    </div>
</section>

@endsection
