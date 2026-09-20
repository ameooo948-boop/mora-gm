@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-mora-bg py-10">
    <div class="mx-auto max-w-7xl px-5">

        {{-- العنوان --}}
        <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="mb-2 text-sm font-medium text-mora-accent">
                    إدارة النادي
                </p>

                <h1 class="font-display text-3xl font-bold text-mora-text">
                    الجلسات التدريبية
                </h1>

                <p class="mt-2 text-sm text-mora-muted">
                    إدارة مواعيد الجلسات التدريبية وأنواعها وحالتها.
                </p>
            </div>

            <a href="{{ route('admin.training-sessions.create') }}" class="inline-flex items-center justify-center rounded-md bg-mora-accent px-5 py-3 text-sm font-bold text-mora-bg transition hover:bg-mora-accent-hover">
                + إضافة جلسة جديدة
            </a>
        </div>

        {{-- البحث والفلاتر --}}
        <div class="mb-6 rounded-xl border border-mora-border bg-mora-surface p-5">
            <form method="GET" action="{{ route('admin.training-sessions.index') }}" class="grid gap-4 md:grid-cols-4">
                <div class="md:col-span-2">
                    <label class="mb-2 block text-sm font-medium text-mora-text">
                        البحث
                    </label>

                    <input type="text" name="search" value="{{ $search }}" placeholder="ابحث باسم الجلسة أو الوصف..." class="w-full rounded-md border border-mora-border bg-mora-card px-4 py-3 text-sm text-mora-text outline-none transition placeholder:text-mora-muted focus:border-mora-accent">
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-mora-text">
                        الفئة
                    </label>

                    <select name="audience" class="w-full rounded-md border border-mora-border bg-mora-card px-4 py-3 text-sm text-mora-text outline-none focus:border-mora-accent">
                        <option value="">الكل</option>
                        <option value="Men" @selected($audience==='Men' )>
                            الرجال
                        </option>
                        <option value="Women" @selected($audience==='Women' )>
                            النساء
                        </option>
                    </select>
                </div>

                <div class="flex items-end gap-2">
                    <button type="submit" class="flex-1 rounded-md bg-mora-accent px-4 py-3 text-sm font-bold text-mora-bg transition hover:bg-mora-accent-hover">
                        بحث
                    </button>

                    <a href="{{ route('admin.training-sessions.index') }}" class="rounded-md border border-mora-border px-4 py-3 text-sm font-medium text-mora-muted transition hover:border-mora-accent hover:text-mora-text">
                        إعادة
                    </a>
                </div>
            </form>
        </div>

        {{-- الجدول --}}
        <div class="overflow-hidden rounded-xl border border-mora-border bg-mora-surface">
            <div class="overflow-x-auto">
                <table class="min-w-full text-right">
                    <thead class="border-b border-mora-border bg-mora-card">
                        <tr>
                            <th class="px-5 py-4 text-xs font-semibold text-mora-muted">
                                الجلسة
                            </th>

                            <th class="px-5 py-4 text-xs font-semibold text-mora-muted">
                                الفئة
                            </th>

                            <th class="px-5 py-4 text-xs font-semibold text-mora-muted">
                                الموعد
                            </th>

                            <th class="px-5 py-4 text-xs font-semibold text-mora-muted">
                                المدربون
                            </th>

                            <th class="px-5 py-4 text-xs font-semibold text-mora-muted">
                                الحالة
                            </th>

                            <th class="px-5 py-4 text-xs font-semibold text-mora-muted">
                                الإجراءات
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-mora-border">
                        @forelse($trainingSessions as $session)
                        <tr class="transition hover:bg-mora-card/60">

                            <td class="px-5 py-5">
                                <div>
                                    <p class="font-semibold text-mora-text">
                                        {{ $session->name }}
                                    </p>

                                    @if($session->description)
                                    <p class="mt-1 max-w-xs truncate text-xs text-mora-muted">
                                        {{ $session->description }}
                                    </p>
                                    @endif
                                </div>
                            </td>

                            <td class="px-5 py-5">
                                @if($session->audience === 'Women')
                                <span class="rounded-full border border-pink-500/20 bg-pink-500/10 px-3 py-1 text-xs text-pink-300">
                                    النساء
                                </span>
                                @else
                                <span class="rounded-full border border-blue-500/20 bg-blue-500/10 px-3 py-1 text-xs text-blue-300">
                                    الرجال
                                </span>
                                @endif
                            </td>

                            <td class="px-5 py-5">
                                <div class="text-sm text-mora-text">
                                    {{ $session->formatted_start_time }}
                                    -
                                    {{ $session->formatted_end_time }}
                                </div>

                                @if($session->endsNextDay())
                                <span class="mt-1 block text-xs text-mora-accent">
                                    يمتد إلى اليوم التالي
                                </span>
                                @endif
                            </td>

                            <td class="px-5 py-5">
                                @forelse($session->trainers as $trainer)
                                <span class="mb-1 inline-block rounded-md bg-mora-card px-2 py-1 text-xs text-mora-muted">
                                    {{ $trainer->name }}
                                </span>
                                @empty
                                <span class="text-xs text-mora-muted">
                                    لا يوجد مدرب
                                </span>
                                @endforelse
                            </td>

                            <td class="px-5 py-5">
                                @if($session->is_active)
                                <span class="rounded-full border border-mora-accent/20 bg-mora-accent/10 px-3 py-1 text-xs font-medium text-mora-accent">
                                    نشطة
                                </span>
                                @else
                                <span class="rounded-full border border-red-500/20 bg-red-500/10 px-3 py-1 text-xs font-medium text-red-300">
                                    غير نشطة
                                </span>
                                @endif
                            </td>

                            <td class="px-5 py-5">
                                <a href="{{ route('admin.training-sessions.edit', $session->id) }}" class="inline-flex rounded-md border border-mora-border px-3 py-2 text-xs font-semibold text-mora-text transition hover:border-mora-accent hover:text-mora-accent">
                                    تعديل
                                </a>
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-5 py-16 text-center">
                                <p class="font-semibold text-mora-text">
                                    لا توجد جلسات تدريبية
                                </p>

                                <p class="mt-2 text-sm text-mora-muted">
                                    لم يتم العثور على أي جلسات مطابقة للبحث.
                                </p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($trainingSessions->hasPages())
            <div class="border-t border-mora-border px-5 py-4">
                {{ $trainingSessions->links() }}
            </div>
            @endif
        </div>

    </div>
</div>
@endsection
