@extends('layouts.app')

@section('content')
<section class="py-16 sm:py-20">
    <div class="mx-auto max-w-5xl px-5">

        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-xs font-semibold tracking-[0.2em] text-mora-accent">
                    إشعاراتي
                </p>

                <h1 class="mt-2 font-display text-4xl font-semibold">
                    الإشعارات
                </h1>

                <p class="mt-3 text-sm leading-7 text-mora-muted">
                    تابع آخر التحديثات المتعلقة بعضويتك وعمليات الدفع.
                </p>
            </div>

            @if ($notifications->total() > 0)
            <form method="POST" action="{{ route('member.notifications.read-all') }}">
                @csrf

                <button type="submit" class="rounded-md border border-mora-border px-4 py-2 text-xs font-semibold transition hover:border-mora-accent hover:text-mora-accent">
                    تحديد الكل كمقروء
                </button>
            </form>
            @endif
        </div>

        <div class="mt-10 space-y-3">
            @forelse ($notifications as $notification)
            <article class="{{ $notification->isRead()
                        ? 'border-mora-border bg-mora-card'
                        : 'border-mora-accent/30 bg-mora-accent/5' }}
                        border p-5 transition">
                <div class="flex items-start justify-between gap-4">

                    <div class="min-w-0">
                        <div class="flex items-center gap-3">

                            <h2 class="text-sm font-bold">
                                {{ $notification->title }}
                            </h2>

                            @if (! $notification->isRead())
                            <span class="rounded-full bg-mora-accent px-2 py-1 text-[10px] font-bold text-mora-bg">
                                جديد
                            </span>
                            @endif

                        </div>

                        <p class="mt-2 text-sm leading-7 text-mora-muted">
                            {{ $notification->message }}
                        </p>

                        <p class="mt-3 text-[11px] text-mora-muted">
                            {{ $notification->created_at?->translatedFormat('d F Y - h:i A') }}
                        </p>
                    </div>

                    @if (! $notification->isRead())
                    <form method="POST" action="{{ route(
                                    'member.notifications.read',
                                    $notification->id
                                ) }}">
                        @csrf

                        <button type="submit" class="whitespace-nowrap text-xs font-semibold text-mora-accent hover:text-mora-accent-hover">
                            تحديد كمقروء
                        </button>
                    </form>
                    @endif

                </div>

                @if ($notification->action_url)
                <a href="{{ $notification->action_url }}" class="mt-4 inline-flex text-xs font-bold text-mora-accent hover:text-mora-accent-hover">
                    عرض التفاصيل ←
                </a>
                @endif
            </article>

            @empty
            <div class="border border-mora-border bg-mora-card px-6 py-14 text-center">
                <p class="font-display text-2xl">
                    لا توجد إشعارات
                </p>

                <p class="mt-2 text-sm text-mora-muted">
                    ستظهر هنا التحديثات الخاصة بعضويتك وعمليات الدفع.
                </p>
            </div>
            @endforelse
        </div>

        @if ($notifications->hasPages())
        <div class="mt-8">
            {{ $notifications->links() }}
        </div>
        @endif

    </div>
</section>
@endsection
