@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-mora-bg py-10">
    <div class="mx-auto max-w-7xl px-5">

        <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="mb-2 text-sm font-medium text-mora-accent">
                    إدارة النادي
                </p>

                <h1 class="font-display text-3xl font-bold text-mora-text">
                    المدربون
                </h1>

                <p class="mt-2 text-sm text-mora-muted">
                    إدارة بيانات المدربين والجلسات التدريبية المرتبطة بهم.
                </p>
            </div>

            <a href="{{ route('admin.trainers.create') }}" class="inline-flex items-center justify-center rounded-md bg-mora-accent px-5 py-3 text-sm font-bold text-mora-bg transition hover:bg-mora-accent-hover">
                + إضافة مدرب
            </a>
        </div>

        {{-- البحث والفلاتر --}}
        <div class="mb-6 rounded-xl border border-mora-border bg-mora-surface p-5">
            <form method="GET" action="{{ route('admin.trainers.index') }}" class="grid gap-4 md:grid-cols-4">
                <div class="md:col-span-2">
                    <label class="mb-2 block text-sm font-medium text-mora-text">
                        البحث
                    </label>

                    <input type="text" name="search" value="{{ $search }}" placeholder="ابحث باسم المدرب أو التخصص..." class="w-full rounded-md border border-mora-border bg-mora-card px-4 py-3 text-sm text-mora-text outline-none placeholder:text-mora-muted focus:border-mora-accent">
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-mora-text">
                        النوع
                    </label>

                    <select name="gender" class="w-full rounded-md border border-mora-border bg-mora-card px-4 py-3 text-sm text-mora-text outline-none focus:border-mora-accent">
                        <option value="">الكل</option>

                        <option value="male" @selected($gender==='male' )>
                            مدربون
                        </option>

                        <option value="female" @selected($gender==='female' )>
                            مدربات
                        </option>
                    </select>
                </div>

                <div class="flex items-end gap-2">
                    <button type="submit" class="flex-1 rounded-md bg-mora-accent px-4 py-3 text-sm font-bold text-mora-bg transition hover:bg-mora-accent-hover">
                        بحث
                    </button>

                    <a href="{{ route('admin.trainers.index') }}" class="rounded-md border border-mora-border px-4 py-3 text-sm font-medium text-mora-muted transition hover:border-mora-accent hover:text-mora-text">
                        إعادة
                    </a>
                </div>
            </form>
        </div>

        {{-- القائمة --}}
        <div class="overflow-hidden rounded-xl border border-mora-border bg-mora-surface">
            <div class="overflow-x-auto">
                <table class="min-w-full text-right">
                    <thead class="border-b border-mora-border bg-mora-card">
                        <tr>
                            <th class="px-5 py-4 text-xs font-semibold text-mora-muted">
                                المدرب
                            </th>

                            <th class="px-5 py-4 text-xs font-semibold text-mora-muted">
                                النوع
                            </th>

                            <th class="px-5 py-4 text-xs font-semibold text-mora-muted">
                                التخصص
                            </th>

                            <th class="px-5 py-4 text-xs font-semibold text-mora-muted">
                                الجلسات
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
                        @forelse($trainers as $trainer)
                        <tr class="transition hover:bg-mora-card/60">

                            <td class="px-5 py-5">
                                <div class="flex items-center gap-3">

                                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-lg border border-mora-border bg-mora-card text-sm font-bold text-mora-accent">
                                        {{ mb_substr($trainer->name, 0, 1) }}
                                    </div>

                                    <div>
                                        <p class="font-semibold text-mora-text">
                                            {{ $trainer->name }}
                                        </p>

                                        <p class="mt-1 text-xs text-mora-muted">
                                            {{ $trainer->slug }}
                                        </p>
                                    </div>
                                </div>
                            </td>

                            <td class="px-5 py-5">
                                @if($trainer->gender === 'female')
                                <span class="rounded-full border border-pink-500/20 bg-pink-500/10 px-3 py-1 text-xs text-pink-300">
                                    مدربة
                                </span>
                                @else
                                <span class="rounded-full border border-blue-500/20 bg-blue-500/10 px-3 py-1 text-xs text-blue-300">
                                    مدرب
                                </span>
                                @endif
                            </td>

                            <td class="px-5 py-5">
                                <span class="text-sm text-mora-text">
                                    {{ $trainer->specialization }}
                                </span>
                            </td>

                            <td class="px-5 py-5">
                                @forelse($trainer->trainingSessions as $session)
                                <span class="mb-1 inline-block rounded-md bg-mora-card px-2 py-1 text-xs text-mora-muted">
                                    {{ $session->name }}
                                </span>
                                @empty
                                <span class="text-xs text-mora-muted">
                                    لا توجد جلسات
                                </span>
                                @endforelse
                            </td>

                            <td class="px-5 py-5">
                                @if($trainer->is_active)
                                <span class="rounded-full border border-mora-accent/20 bg-mora-accent/10 px-3 py-1 text-xs font-medium text-mora-accent">
                                    نشط
                                </span>
                                @else
                                <span class="rounded-full border border-red-500/20 bg-red-500/10 px-3 py-1 text-xs font-medium text-red-300">
                                    غير نشط
                                </span>
                                @endif
                            </td>

                            <td class="px-5 py-5">
                                <a href="{{ route('admin.trainers.edit', $trainer->id) }}" class="inline-flex rounded-md border border-mora-border px-3 py-2 text-xs font-semibold text-mora-text transition hover:border-mora-accent hover:text-mora-accent">
                                    تعديل
                                </a>
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-5 py-16 text-center">
                                <p class="font-semibold text-mora-text">
                                    لا يوجد مدربون
                                </p>

                                <p class="mt-2 text-sm text-mora-muted">
                                    لم يتم العثور على مدربين مطابقين للبحث.
                                </p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($trainers->hasPages())
            <div class="border-t border-mora-border px-5 py-4">
                {{ $trainers->links() }}
            </div>
            @endif
        </div>

    </div>
</div>
@endsection
