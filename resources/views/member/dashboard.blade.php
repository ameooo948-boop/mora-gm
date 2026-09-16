@extends('layouts.app')

@section('content')

<section class="min-h-screen bg-mora-bg px-5 pb-20 pt-32">

    <div class="mx-auto max-w-7xl">

        {{-- Header --}}
        <div class="mb-10">

            <p class="mb-3 text-sm font-semibold tracking-[0.2em] text-mora-accent">
                لوحة التحكم
            </p>

            <div class="flex flex-col justify-between gap-5 md:flex-row md:items-end">

                <div>
                    <h1 class="font-display text-5xl font-bold text-mora-text md:text-6xl">
                        أهلاً بك، {{ $user->name }}
                    </h1>

                    <p class="mt-3 text-mora-muted">
                        تابع عضويتك وحضورك وكل ما يتعلق برحلتك في MORA.
                    </p>
                </div>

                <a href="{{ route('member.subscription') }}" class="inline-flex w-fit items-center justify-center rounded-md bg-mora-accent px-6 py-3 font-semibold text-mora-bg transition hover:bg-mora-accent-hover">
                    عرض عضويتي
                </a>

            </div>

        </div>


        {{-- Membership Status --}}
        @if ($activeSubscription)

        <div class="mb-8 overflow-hidden rounded-xl border border-mora-border bg-mora-card">

            <div class="flex flex-col justify-between gap-6 p-6 md:flex-row md:items-center md:p-8">

                <div>

                    <div class="mb-3 flex items-center gap-3">

                        <span class="h-2.5 w-2.5 rounded-full bg-mora-accent"></span>

                        <span class="text-sm font-semibold text-mora-accent">
                            عضويتك فعالة
                        </span>

                    </div>

                    <h2 class="font-display text-4xl font-bold text-mora-text">
                        {{ $activeSubscription->membershipPlan->name }}
                    </h2>

                    <p class="mt-2 text-mora-muted">
                        عضويتك مستمرة حتى
                        {{ $activeSubscription->ends_at->format('d/m/Y') }}
                    </p>

                </div>


                <div class="grid grid-cols-2 gap-4 sm:grid-cols-3">

                    <div class="min-w-[120px] border-l border-mora-border px-4">
                        <p class="text-sm text-mora-muted">
                            القيمة
                        </p>

                        <p class="mt-2 font-display text-2xl font-bold text-mora-text">
                            {{ number_format((float) $activeSubscription->price, 0) }}
                            <span class="text-xs font-normal text-mora-muted">
                                جنيه
                            </span>
                        </p>
                    </div>


                    <div class="min-w-[120px] border-l border-mora-border px-4">
                        <p class="text-sm text-mora-muted">
                            البداية
                        </p>

                        <p class="mt-2 font-semibold text-mora-text">
                            {{ $activeSubscription->starts_at->format('d/m/Y') }}
                        </p>
                    </div>


                    <div class="min-w-[120px] px-4">
                        <p class="text-sm text-mora-muted">
                            المتبقي
                        </p>

                        <p class="mt-2 font-display text-2xl font-bold text-mora-accent">
                            {{ max(0, now()->diffInDays($activeSubscription->ends_at, false)) }}
                            <span class="text-xs font-normal text-mora-muted">
                                يوم
                            </span>
                        </p>
                    </div>

                </div>

            </div>

        </div>

        @else

        <div class="mb-8 rounded-xl border border-mora-border bg-mora-card p-8">

            <p class="text-sm font-semibold text-mora-accent">
                العضوية
            </p>

            <h2 class="mt-2 font-display text-3xl font-bold text-mora-text">
                لا يوجد اشتراك فعال
            </h2>

            <p class="mt-2 max-w-xl text-mora-muted">
                اختر إحدى عضويات MORA وابدأ رحلتك التدريبية معنا.
            </p>

            <a href="{{ route('home') }}#memberships" class="mt-6 inline-flex rounded-md bg-mora-accent px-5 py-3 font-semibold text-mora-bg transition hover:bg-mora-accent-hover">
                استعرض العضويات
            </a>

        </div>

        @endif


        {{-- Quick Actions --}}
        <div class="mb-10">

            <h2 class="mb-5 font-display text-3xl font-bold text-mora-text">
                الوصول السريع
            </h2>

            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">

                <a href="{{ route('member.subscription') }}" class="group rounded-xl border border-mora-border bg-mora-card p-6 transition hover:border-mora-accent">
                    <span class="text-sm text-mora-accent">
                        01
                    </span>

                    <h3 class="mt-5 font-display text-2xl font-bold text-mora-text">
                        عضويتي
                    </h3>

                    <p class="mt-2 text-sm text-mora-muted">
                        تفاصيل العضوية والاشتراكات السابقة.
                    </p>
                </a>


                <div class="rounded-xl border border-mora-border bg-mora-card p-6">

                    <span class="text-sm text-mora-accent">
                        02
                    </span>

                    <h3 class="mt-5 font-display text-2xl font-bold text-mora-text">
                        الحضور
                    </h3>

                    <p class="mt-2 text-sm text-mora-muted">
                        سجل حضورك في MORA.
                    </p>

                    <span class="mt-4 inline-block text-xs text-mora-muted">
                        قريبًا
                    </span>

                </div>


                <div class="rounded-xl border border-mora-border bg-mora-card p-6">

                    <span class="text-sm text-mora-accent">
                        03
                    </span>

                    <h3 class="mt-5 font-display text-2xl font-bold text-mora-text">
                        الملف الشخصي
                    </h3>

                    <p class="mt-2 text-sm text-mora-muted">
                        إدارة بيانات حسابك الشخصية.
                    </p>

                    <span class="mt-4 inline-block text-xs text-mora-muted">
                        قريبًا
                    </span>

                </div>


                <div class="rounded-xl border border-mora-border bg-mora-card p-6">

                    <span class="text-sm text-mora-accent">
                        04
                    </span>

                    <h3 class="mt-5 font-display text-2xl font-bold text-mora-text">
                        الإشعارات
                    </h3>

                    <p class="mt-2 text-sm text-mora-muted">
                        آخر التنبيهات والتحديثات الخاصة بك.
                    </p>

                    <span class="mt-4 inline-block text-xs text-mora-muted">
                        قريبًا
                    </span>

                </div>

            </div>

        </div>


        {{-- Recent Subscriptions --}}
        <div>

            <div class="mb-5 flex items-end justify-between gap-4">

                <div>
                    <h2 class="font-display text-3xl font-bold text-mora-text">
                        آخر الاشتراكات
                    </h2>

                    <p class="mt-2 text-mora-muted">
                        أحدث اشتراكاتك في MORA.
                    </p>
                </div>

                <a href="{{ route('member.subscription') }}" class="text-sm font-semibold text-mora-accent transition hover:text-mora-accent-hover">
                    عرض الكل
                </a>

            </div>


            <div class="overflow-hidden rounded-xl border border-mora-border bg-mora-card">

                @forelse ($subscriptions as $subscription)

                <div class="flex flex-col gap-4 border-b border-mora-border p-6 last:border-b-0 sm:flex-row sm:items-center sm:justify-between">

                    <div>

                        <h3 class="font-semibold text-mora-text">
                            {{ $subscription->membershipPlan->name }}
                        </h3>

                        <p class="mt-1 text-sm text-mora-muted">
                            {{ $subscription->starts_at->format('d/m/Y') }}
                            -
                            {{ $subscription->ends_at->format('d/m/Y') }}
                        </p>

                    </div>


                    <div class="flex items-center gap-5">

                        <span class="font-semibold text-mora-text">
                            {{ number_format((float) $subscription->price, 0) }}
                            جنيه
                        </span>


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

                    </div>

                </div>

                @empty

                <div class="p-8 text-center">

                    <p class="text-mora-muted">
                        لا توجد اشتراكات حتى الآن.
                    </p>

                </div>

                @endforelse

            </div>

        </div>

    </div>

</section>

@endsection
