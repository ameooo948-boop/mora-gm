@extends('layouts.app')

@section('content')

<section class="min-h-screen bg-mora-bg py-24">
    <div class="mx-auto max-w-7xl px-5">

        <div class="mb-12">
            <p class="mb-3 text-xs font-semibold uppercase tracking-[0.25em] text-mora-accent">
                MORA ADMIN
            </p>

            <h1 class="font-display text-4xl font-bold text-mora-text md:text-5xl">
                الحضور والانصراف
            </h1>

            <p class="mt-4 text-sm text-mora-muted">
                متابعة سجلات حضور وانصراف أعضاء MORA GYM.
            </p>
        </div>

        <div class="overflow-hidden border border-mora-border bg-mora-card">

            @forelse ($attendances as $attendance)

            <div class="grid gap-5 border-b border-mora-border p-6 last:border-b-0 md:grid-cols-4 md:items-center">

                <div>
                    <p class="text-xs text-mora-muted">
                        العضو
                    </p>

                    <p class="mt-1 font-semibold text-mora-text">
                        {{ $attendance->user->name }}
                    </p>

                    <p class="mt-1 text-xs text-mora-muted">
                        {{ $attendance->user->email }}
                    </p>
                </div>

                <div>
                    <p class="text-xs text-mora-muted">
                        الجلسة
                    </p>

                    <p class="mt-1 text-sm text-mora-text">
                        {{ $attendance->trainingSession->name }}
                    </p>
                </div>

                <div>
                    <p class="text-xs text-mora-muted">
                        التاريخ
                    </p>

                    <p class="mt-1 text-sm text-mora-text">
                        {{ $attendance->attendance_date->format('d/m/Y') }}
                    </p>
                </div>

                <div>
                    <p class="text-xs text-mora-muted">
                        الحالة
                    </p>

                    <div class="mt-2 flex flex-wrap gap-3 text-xs">

                        <span class="border border-mora-accent/30 px-3 py-1 text-mora-accent">
                            حضور:
                            {{ $attendance->checked_in_at?->format('h:i A') ?? '—' }}
                        </span>

                        <span class="border border-mora-border px-3 py-1 text-mora-muted">
                            انصراف:
                            {{ $attendance->checked_out_at?->format('h:i A') ?? 'لم يسجل' }}
                        </span>

                    </div>
                </div>

            </div>

            @empty

            <div class="p-10 text-center">
                <p class="text-sm text-mora-muted">
                    لا توجد سجلات حضور حتى الآن.
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
</section>

@endsection
