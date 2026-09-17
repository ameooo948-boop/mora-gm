@extends('layouts.app')

@section('content')

<section class="min-h-screen bg-mora-bg py-24">
    <div class="mx-auto max-w-7xl px-5">

        <div class="mb-12">
            <p class="mb-3 text-xs font-semibold uppercase tracking-[0.25em] text-mora-accent">
                MORA ADMIN
            </p>

            <h1 class="font-display text-4xl font-bold text-mora-text md:text-5xl">
                لوحة الإدارة
            </h1>

            <p class="mt-4 text-sm text-mora-muted">
                نظرة سريعة على حالة MORA GYM والعمليات اليومية.
            </p>
        </div>

        {{-- Statistics --}}
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-5">

            <div class="border border-mora-border bg-mora-card p-6">
                <p class="text-xs text-mora-muted">
                    إجمالي الأعضاء
                </p>

                <p class="mt-3 font-display text-4xl font-bold text-mora-text">
                    {{ $membersCount }}
                </p>
            </div>

            <div class="border border-mora-border bg-mora-card p-6">
                <p class="text-xs text-mora-muted">
                    أعضاء فعالون
                </p>

                <p class="mt-3 font-display text-4xl font-bold text-mora-accent">
                    {{ $activeMembersCount }}
                </p>
            </div>

            <div class="border border-mora-border bg-mora-card p-6">
                <p class="text-xs text-mora-muted">
                    عضويات فعالة
                </p>

                <p class="mt-3 font-display text-4xl font-bold text-mora-text">
                    {{ $activeSubscriptionsCount }}
                </p>
            </div>

            <a href="{{ route('admin.payments.index') }}" class="border border-mora-border bg-mora-card p-6 transition hover:border-mora-accent">
                <p class="text-xs text-mora-muted">
                    مدفوعات قيد المراجعة
                </p>

                <p class="mt-3 font-display text-4xl font-bold text-yellow-400">
                    {{ $pendingPaymentsCount }}
                </p>
            </a>

            <a href="{{ route('admin.attendance.index') }}" class="border border-mora-border bg-mora-card p-6 transition hover:border-mora-accent">
                <p class="text-xs text-mora-muted">
                    حضور اليوم
                </p>

                <p class="mt-3 font-display text-4xl font-bold text-mora-text">
                    {{ $todayAttendanceCount }}
                </p>
            </a>

        </div>

        {{-- Quick Actions --}}
        <div class="mt-12">

            <div class="mb-6">
                <p class="text-xs uppercase tracking-[0.2em] text-mora-muted">
                    الإدارة
                </p>

                <h2 class="mt-2 font-display text-2xl font-semibold text-mora-text">
                    الوصول السريع
                </h2>
            </div>

            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">

                <a href="{{ route('admin.payments.index') }}" class="border border-mora-border bg-mora-card p-6 transition hover:border-mora-accent">
                    <h3 class="font-display text-xl font-semibold text-mora-text">
                        المدفوعات
                    </h3>

                    <p class="mt-2 text-sm leading-6 text-mora-muted">
                        مراجعة طلبات الدفع وتأكيد أو رفض التحويلات.
                    </p>
                </a>

                <a href="{{ route('admin.attendance.index') }}" class="border border-mora-border bg-mora-card p-6 transition hover:border-mora-accent">
                    <h3 class="font-display text-xl font-semibold text-mora-text">
                        الحضور
                    </h3>

                    <p class="mt-2 text-sm leading-6 text-mora-muted">
                        متابعة حضور وانصراف أعضاء الجيم.
                    </p>
                </a>

                <a href="{{ route('admin.members.index') }}" class="border border-mora-border bg-mora-card p-6 transition hover:border-mora-accent">
                    <h3 class="font-display text-xl font-semibold text-mora-text">
                        الأعضاء
                    </h3>

                    <p class="mt-2 text-sm leading-6 text-mora-muted">
                        عرض الأعضاء ومتابعة العضويات والحضور.
                    </p>
                </a>

                <a href="{{ route('admin.subscriptions.index') }}" class="border border-mora-border bg-mora-card p-6 transition hover:border-mora-accent">
                    <h3 class="font-display text-xl font-semibold text-mora-text">
                        الاشتراكات
                    </h3>

                    <p class="mt-2 text-sm leading-6 text-mora-muted">
                        متابعة جميع اشتراكات أعضاء MORA وحالاتها.
                    </p>
                </a>

                <a href="{{ route('home') }}#memberships" class="border border-mora-border bg-mora-card p-6 transition hover:border-mora-accent">
                    <h3 class="font-display text-xl font-semibold text-mora-text">
                        الباقات
                    </h3>

                    <p class="mt-2 text-sm leading-6 text-mora-muted">
                        مراجعة الباقات وأسعار الاشتراك الحالية.
                    </p>
                </a>

                <a href="{{ route('home') }}" class="border border-mora-border bg-mora-card p-6 transition hover:border-mora-accent">
                    <h3 class="font-display text-xl font-semibold text-mora-text">
                        الموقع
                    </h3>

                    <p class="mt-2 text-sm leading-6 text-mora-muted">
                        الانتقال إلى الموقع الرئيسي.
                    </p>
                </a>

            </div>

        </div>

    </div>
</section>

@endsection
