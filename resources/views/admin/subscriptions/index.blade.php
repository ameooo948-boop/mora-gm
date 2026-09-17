@extends('layouts.app')

@section('content')

<section class="min-h-screen bg-mora-bg py-24">
    <div class="mx-auto max-w-7xl px-5">

        <div class="mb-10">
            <p class="mb-3 text-xs font-semibold uppercase tracking-[0.25em] text-mora-accent">
                MORA ADMIN
            </p>

            <h1 class="font-display text-4xl font-bold text-mora-text md:text-5xl">
                الاشتراكات
            </h1>

            <p class="mt-3 text-sm text-mora-muted">
                متابعة اشتراكات أعضاء MORA GYM وحالتها.
            </p>
        </div>

        {{-- Filters --}}
        <form method="GET" action="{{ route('admin.subscriptions.index') }}" class="mb-8 grid gap-3 md:grid-cols-[1fr_220px_auto_auto]">

            <input type="text" name="search" value="{{ $search }}" placeholder="ابحث باسم العضو أو البريد أو الهاتف..." class="rounded-md border border-mora-border bg-mora-card px-4 py-3 text-sm text-mora-text outline-none transition placeholder:text-mora-muted focus:border-mora-accent">

            <select name="status" class="rounded-md border border-mora-border bg-mora-card px-4 py-3 text-sm text-mora-text outline-none focus:border-mora-accent">
                <option value="">كل الحالات</option>

                <option value="active" @selected($status==='active' )>
                    فعالة
                </option>

                <option value="pending" @selected($status==='pending' )>
                    قيد الانتظار
                </option>

                <option value="expired" @selected($status==='expired' )>
                    منتهية
                </option>

                <option value="cancelled" @selected($status==='cancelled' )>
                    ملغاة
                </option>
            </select>

            <button type="submit" class="rounded-md bg-mora-accent px-7 py-3 text-sm font-bold text-mora-bg transition hover:bg-mora-accent-hover">
                بحث
            </button>

            @if ($search || $status)
            <a href="{{ route('admin.subscriptions.index') }}" class="rounded-md border border-mora-border px-7 py-3 text-center text-sm font-semibold text-mora-text transition hover:border-mora-accent hover:text-mora-accent">
                مسح
            </a>
            @endif

        </form>

        {{-- Subscriptions --}}
        <div class="overflow-hidden border border-mora-border bg-mora-card">

            @forelse ($subscriptions as $subscription)

            <a href="{{ route('admin.subscriptions.show', $subscription->id) }}" class="block border-b border-mora-border p-6 transition last:border-b-0 hover:bg-mora-surface">

                <div class="grid gap-5 md:grid-cols-5 md:items-center">

                    <div>
                        <p class="font-semibold text-mora-text">
                            {{ $subscription->user->name }}
                        </p>

                        <p class="mt-1 text-xs text-mora-muted">
                            {{ $subscription->user->email }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs text-mora-muted">
                            الباقة
                        </p>

                        <p class="mt-1 text-sm text-mora-text">
                            {{ $subscription->membershipPlan->name }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs text-mora-muted">
                            المبلغ
                        </p>

                        <p class="mt-1 font-display text-lg text-mora-text">
                            {{ number_format((float) $subscription->price, 0) }}
                            جنيه
                        </p>
                    </div>

                    <div>
                        <p class="text-xs text-mora-muted">
                            الفترة
                        </p>

                        @if ($subscription->starts_at && $subscription->ends_at)

                        <p class="mt-1 text-xs text-mora-text">
                            {{ $subscription->starts_at->format('d/m/Y') }}
                            →
                            {{ $subscription->ends_at->format('d/m/Y') }}
                        </p>

                        @else

                        <p class="mt-1 text-xs text-mora-muted">
                            لم تبدأ بعد
                        </p>

                        @endif
                    </div>

                    <div>
                        @switch($subscription->status->value)

                        @case('active')
                        <span class="border border-mora-accent/30 px-3 py-1 text-xs font-semibold text-mora-accent">
                            فعالة
                        </span>
                        @break

                        @case('pending')
                        <span class="border border-yellow-500/30 px-3 py-1 text-xs font-semibold text-yellow-400">
                            قيد الانتظار
                        </span>
                        @break

                        @case('expired')
                        <span class="border border-mora-border px-3 py-1 text-xs font-semibold text-mora-muted">
                            منتهية
                        </span>
                        @break

                        @case('cancelled')
                        <span class="border border-red-500/30 px-3 py-1 text-xs font-semibold text-red-400">
                            ملغاة
                        </span>
                        @break

                        @endswitch
                    </div>

                </div>

            </a>

            @empty

            <div class="p-10 text-center">
                <p class="text-sm text-mora-muted">
                    لا توجد اشتراكات مطابقة للبحث.
                </p>
            </div>

            @endforelse

        </div>

        @if ($subscriptions->hasPages())
        <div class="mt-6">
            {{ $subscriptions->links() }}
        </div>
        @endif

    </div>
</section>

@endsection
