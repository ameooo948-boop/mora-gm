@extends('layouts.app')

@section('content')

<section class="min-h-screen bg-mora-bg py-24">
    <div class="mx-auto max-w-7xl px-5">

        <div class="mb-10">
            <p class="mb-3 text-xs font-semibold uppercase tracking-[0.25em] text-mora-accent">
                MORA ADMIN
            </p>

            <h1 class="font-display text-4xl font-bold text-mora-text">
                الأعضاء
            </h1>

            <p class="mt-3 text-sm text-mora-muted">
                إدارة ومتابعة أعضاء MORA GYM.
            </p>
        </div>

        {{-- Search --}}
        <form method="GET" action="{{ route('admin.members.index') }}" class="mb-8 flex flex-col gap-3 sm:flex-row">
            <input type="text" name="search" value="{{ $search }}" placeholder="ابحث بالاسم أو البريد الإلكتروني أو الهاتف..." class="w-full rounded-md border border-mora-border bg-mora-card px-4 py-3 text-sm text-mora-text outline-none transition placeholder:text-mora-muted focus:border-mora-accent">

            <button type="submit" class="rounded-md bg-mora-accent px-7 py-3 text-sm font-bold text-mora-bg transition hover:bg-mora-accent-hover">
                بحث
            </button>

            @if ($search)
            <a href="{{ route('admin.members.index') }}" class="rounded-md border border-mora-border px-7 py-3 text-center text-sm font-semibold text-mora-text transition hover:border-mora-accent hover:text-mora-accent">
                مسح
            </a>
            @endif
        </form>

        {{-- Members --}}
        <div class="overflow-hidden border border-mora-border bg-mora-card">

            @forelse ($members as $member)

            <a href="{{ route('admin.members.show', $member->id) }}" class="block border-b border-mora-border p-6 transition last:border-b-0 hover:bg-mora-surface">

                <div class="grid gap-5 md:grid-cols-4 md:items-center">

                    <div>
                        <p class="font-semibold text-mora-text">
                            {{ $member->name }}
                        </p>

                        <p class="mt-1 text-xs text-mora-muted">
                            {{ $member->email }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs text-mora-muted">
                            الهاتف
                        </p>

                        <p class="mt-1 text-sm text-mora-text">
                            {{ $member->phone ?: 'غير مسجل' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs text-mora-muted">
                            النوع
                        </p>

                        <p class="mt-1 text-sm text-mora-text">
                            {{ $member->gender?->label() ?? 'غير محدد' }}
                        </p>
                    </div>

                    <div>
                        @if ($member->activeSubscription)

                        <span class="border border-mora-accent/30 px-3 py-1 text-xs font-semibold text-mora-accent">
                            عضوية فعالة
                        </span>

                        <p class="mt-2 text-xs text-mora-muted">
                            تنتهي في
                            {{ $member->activeSubscription->ends_at?->format('d/m/Y') ?? '—' }}
                        </p>

                        @else

                        <span class="border border-mora-border px-3 py-1 text-xs font-semibold text-mora-muted">
                            لا توجد عضوية فعالة
                        </span>

                        @endif
                    </div>

                </div>

            </a>

            @empty

            <div class="p-10 text-center">
                <p class="text-sm text-mora-muted">
                    لا يوجد أعضاء مطابقون للبحث.
                </p>
            </div>

            @endforelse

        </div>

        @if ($members->hasPages())
        <div class="mt-6">
            {{ $members->links() }}
        </div>
        @endif

    </div>
</section>

@endsection
