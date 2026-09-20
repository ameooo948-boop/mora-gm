@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-7xl px-5 py-10">

    <div class="mb-8 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="font-display text-3xl font-bold text-white">
                خطط العضوية
            </h1>

            <p class="mt-2 text-sm text-mora-muted">
                إدارة أسعار ومدد ومميزات اشتراكات الجيم.
            </p>
        </div>

        <a href="{{ route('admin.membership-plans.create') }}" class="inline-flex items-center justify-center rounded-md bg-mora-accent px-5 py-3 text-sm font-bold text-black transition hover:bg-mora-accent-hover">
            + إضافة خطة جديدة
        </a>
    </div>

    <form method="GET" class="mb-6">
        <div class="flex flex-col gap-3 sm:flex-row">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="ابحث باسم الخطة أو الوصف..." class="w-full rounded-md border border-mora-border bg-mora-card px-4 py-3 text-sm text-white outline-none placeholder:text-mora-muted focus:border-mora-accent">

            <button type="submit" class="rounded-md border border-mora-border bg-mora-surface px-6 py-3 text-sm font-semibold text-white transition hover:border-mora-accent">
                بحث
            </button>
        </div>
    </form>

    <div class="overflow-hidden rounded-lg border border-mora-border bg-mora-card">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[900px] text-right">
                <thead class="border-b border-mora-border bg-mora-surface">
                    <tr>
                        <th class="px-5 py-4 text-sm font-semibold text-mora-muted">الخطة</th>
                        <th class="px-5 py-4 text-sm font-semibold text-mora-muted">المدة</th>
                        <th class="px-5 py-4 text-sm font-semibold text-mora-muted">السعر</th>
                        <th class="px-5 py-4 text-sm font-semibold text-mora-muted">الحالة</th>
                        <th class="px-5 py-4 text-sm font-semibold text-mora-muted">مميزة</th>
                        <th class="px-5 py-4 text-sm font-semibold text-mora-muted">الترتيب</th>
                        <th class="px-5 py-4 text-sm font-semibold text-mora-muted">الإجراءات</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-mora-border">
                    @forelse($plans as $plan)
                    <tr class="transition hover:bg-mora-surface">

                        <td class="px-5 py-5">
                            <div class="font-semibold text-white">
                                {{ $plan->name }}
                            </div>

                            @if($plan->short_description)
                            <div class="mt-1 text-xs text-mora-muted">
                                {{ $plan->short_description }}
                            </div>
                            @endif
                        </td>

                        <td class="px-5 py-5 text-sm text-mora-muted">
                            {{ $plan->duration_days }} يوم
                        </td>

                        <td class="px-5 py-5">
                            <span class="font-display text-lg font-bold text-mora-accent">
                                {{ number_format((float) $plan->price, 2) }}
                            </span>

                            <span class="text-xs text-mora-muted">
                                جنيه
                            </span>
                        </td>

                        <td class="px-5 py-5">
                            @if($plan->is_active)
                            <span class="rounded-full bg-lime-400/10 px-3 py-1 text-xs font-semibold text-mora-accent">
                                مفعلة
                            </span>
                            @else
                            <span class="rounded-full bg-red-500/10 px-3 py-1 text-xs font-semibold text-red-400">
                                غير مفعلة
                            </span>
                            @endif
                        </td>

                        <td class="px-5 py-5">
                            @if($plan->is_featured)
                            <span class="text-sm font-semibold text-mora-accent">
                                نعم
                            </span>
                            @else
                            <span class="text-sm text-mora-muted">
                                لا
                            </span>
                            @endif
                        </td>

                        <td class="px-5 py-5 text-sm text-mora-muted">
                            {{ $plan->sort_order }}
                        </td>

                        <td class="px-5 py-5">
                            <a href="{{ route('admin.membership-plans.edit', $plan) }}" class="inline-flex rounded-md border border-mora-border px-4 py-2 text-sm font-semibold text-white transition hover:border-mora-accent hover:text-mora-accent">
                                تعديل
                            </a>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-5 py-16 text-center">
                            <div class="text-lg font-semibold text-white">
                                لا توجد خطط عضوية
                            </div>

                            <p class="mt-2 text-sm text-mora-muted">
                                أضف أول خطة عضوية للموقع.
                            </p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($plans->hasPages())
        <div class="border-t border-mora-border px-5 py-4">
            {{ $plans->links() }}
        </div>
        @endif
    </div>

</div>
@endsection
