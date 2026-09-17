@extends('layouts.app')

@section('content')

<section class="min-h-screen bg-mora-bg py-24">
    <div class="mx-auto max-w-7xl px-5">

        {{-- Header --}}
        <div class="mb-12">
            <p class="mb-3 text-xs font-semibold uppercase tracking-[0.25em] text-mora-accent">
                MORA GYM
            </p>

            <h1 class="font-display text-4xl font-bold uppercase tracking-tight text-mora-text md:text-5xl">
                الحضور والانصراف
            </h1>

            <p class="mt-4 max-w-2xl text-sm leading-7 text-mora-muted">
                سجل حضورك وانصرافك وتابع سجل زياراتك للجيم.
            </p>
        </div>

        {{-- Sessions --}}
        <div class="mb-16">
            <div class="mb-6 flex items-end justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-mora-muted">
                        الجلسات اليومية
                    </p>

                    <h2 class="mt-2 font-display text-2xl font-semibold text-mora-text">
                        اختر الجلسة
                    </h2>
                </div>
            </div>

            <div class="grid gap-5 md:grid-cols-2">

                @forelse ($trainingSessions as $session)

                <div class="border border-mora-border bg-mora-card p-6">

                    <div class="mb-6 flex items-start justify-between gap-4">

                        <div>
                            <h3 class="font-display text-2xl font-semibold text-mora-text">
                                {{ $session->name }}
                            </h3>

                            <p class="mt-2 text-sm text-mora-muted">
                                {{ $session->description }}
                            </p>
                        </div>

                        <span class="shrink-0 border border-mora-accent/30 px-3 py-1 text-xs font-semibold text-mora-accent">
                            {{ $session->audience === 'Women' ? 'السيدات' : 'الرجال' }}
                        </span>

                    </div>

                    <div class="mb-6 flex items-center justify-between border-y border-mora-border py-4">

                        <div>
                            <p class="text-xs text-mora-muted">
                                البداية
                            </p>

                            <p class="mt-1 font-display text-xl text-mora-text">
                                {{ $session->formatted_start_time ?? '—' }}
                            </p>
                        </div>

                        <div class="text-center text-mora-muted">
                            →
                        </div>

                        <div class="text-left">
                            <p class="text-xs text-mora-muted">
                                النهاية
                            </p>

                            <p class="mt-1 font-display text-xl text-mora-text">
                                {{ $session->formatted_end_time ?? '—' }}
                            </p>

                            @if ($session->ends_next_day)
                            <span class="text-[10px] text-mora-accent">
                                اليوم التالي
                            </span>
                            @endif
                        </div>

                    </div>

                    <div class="flex gap-3">

                        <form method="POST" action="{{ route('member.attendance.check-in', $session) }}" class="flex-1">
                            @csrf

                            <button type="submit" class="w-full rounded-md bg-mora-accent px-4 py-3 text-sm font-bold text-mora-bg transition hover:bg-mora-accent-hover">
                                تسجيل الحضور
                            </button>
                        </form>

                        <form method="POST" action="{{ route('member.attendance.check-out', $session) }}" class="flex-1">
                            @csrf

                            <button type="submit" class="w-full rounded-md border border-mora-border px-4 py-3 text-sm font-semibold text-mora-text transition hover:border-mora-accent hover:text-mora-accent">
                                تسجيل الانصراف
                            </button>
                        </form>

                    </div>

                </div>

                @empty

                <div class="border border-mora-border bg-mora-card p-8 text-center md:col-span-2">
                    <p class="text-sm text-mora-muted">
                        لا توجد جلسات تدريب متاحة حاليًا.
                    </p>
                </div>

                @endforelse

            </div>
        </div>

        {{-- Attendance History --}}
        <div>

            <div class="mb-6">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-mora-muted">
                    السجل
                </p>

                <h2 class="mt-2 font-display text-2xl font-semibold text-mora-text">
                    سجل الحضور
                </h2>
            </div>

            <div class="overflow-hidden border border-mora-border bg-mora-card">

                @forelse ($attendances as $attendance)

                <div class="flex flex-col gap-5 border-b border-mora-border p-6 last:border-b-0 md:flex-row md:items-center md:justify-between">

                    <div>
                        <h3 class="font-display text-xl font-semibold text-mora-text">
                            {{ $attendance->trainingSession->name }}
                        </h3>

                        <p class="mt-1 text-sm text-mora-muted">
                            {{ $attendance->attendance_date->format('d/m/Y') }}
                        </p>
                    </div>

                    <div class="grid grid-cols-2 gap-8 text-sm">

                        <div>
                            <p class="text-xs text-mora-muted">
                                الحضور
                            </p>

                            <p class="mt-1 text-mora-text">
                                {{ $attendance->checked_in_at?->format('h:i A') ?? '—' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-xs text-mora-muted">
                                الانصراف
                            </p>

                            <p class="mt-1 text-mora-text">
                                {{ $attendance->checked_out_at?->format('h:i A') ?? 'لم يسجل' }}
                            </p>
                        </div>

                    </div>

                    <div>
                        @if ($attendance->checked_out_at)
                        <span class="border border-mora-accent/30 px-3 py-1 text-xs font-semibold text-mora-accent">
                            مكتمل
                        </span>
                        @else
                        <span class="border border-yellow-500/30 px-3 py-1 text-xs font-semibold text-yellow-400">
                            داخل الجيم
                        </span>
                        @endif
                    </div>

                </div>

                @empty

                <div class="p-10 text-center">
                    <p class="text-sm text-mora-muted">
                        لم تقم بتسجيل أي حضور حتى الآن.
                    </p>
                </div>

                @endforelse

            </div>

            @if ($attendances->hasPages())
            <div class="mt-6">
                {{ $attendances->links() }}
            </div>
            @endif

        </div>

    </div>
</section>

@endsection
