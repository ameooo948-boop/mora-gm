@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-7xl px-5 py-10">

    <div class="mb-8 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="font-display text-3xl font-bold text-white">
                إعدادات الجيم
            </h1>

            <p class="mt-2 text-sm text-mora-muted">
                إدارة بيانات ومعلومات MORA GYM الظاهرة على الموقع.
            </p>
        </div>

        @if($profiles->isEmpty())
        <a href="{{ route('admin.gym-profile.create') }}" class="inline-flex items-center justify-center rounded-md bg-mora-accent px-5 py-3 text-sm font-bold text-black transition hover:bg-mora-accent-hover">
            + إضافة بيانات الجيم
        </a>
        @endif
    </div>

    <div class="overflow-hidden rounded-lg border border-mora-border bg-mora-card">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[900px] text-right">

                <thead class="border-b border-mora-border bg-mora-surface">
                    <tr>
                        <th class="px-5 py-4 text-sm font-semibold text-mora-muted">
                            اسم الجيم
                        </th>

                        <th class="px-5 py-4 text-sm font-semibold text-mora-muted">
                            المساحة
                        </th>

                        <th class="px-5 py-4 text-sm font-semibold text-mora-muted">
                            المدربون
                        </th>

                        <th class="px-5 py-4 text-sm font-semibold text-mora-muted">
                            الهاتف
                        </th>

                        <th class="px-5 py-4 text-sm font-semibold text-mora-muted">
                            الحالة
                        </th>

                        <th class="px-5 py-4 text-sm font-semibold text-mora-muted">
                            الإجراءات
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-mora-border">

                    @forelse($profiles as $profile)
                    <tr class="transition hover:bg-mora-surface">

                        <td class="px-5 py-5">
                            <div class="font-semibold text-white">
                                {{ $profile->name }}
                            </div>

                            @if($profile->eyebrow)
                            <div class="mt-1 text-xs text-mora-muted">
                                {{ $profile->eyebrow }}
                            </div>
                            @endif
                        </td>

                        <td class="px-5 py-5 text-sm text-mora-muted">
                            {{ $profile->space_size }} م²
                        </td>

                        <td class="px-5 py-5 text-sm text-mora-muted">
                            {{ $profile->trainer_count }}
                        </td>

                        <td class="px-5 py-5 text-sm text-mora-muted">
                            {{ $profile->phone ?: 'غير مضاف' }}
                        </td>

                        <td class="px-5 py-5">
                            @if($profile->is_active)
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
                            <a href="{{ route('admin.gym-profile.edit', $profile) }}" class="inline-flex rounded-md border border-mora-border px-4 py-2 text-sm font-semibold text-white transition hover:border-mora-accent hover:text-mora-accent">
                                تعديل
                            </a>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-5 py-16 text-center">

                            <div class="text-lg font-semibold text-white">
                                لا توجد بيانات للجيم
                            </div>

                            <p class="mt-2 text-sm text-mora-muted">
                                أضف بيانات MORA GYM لعرضها على الموقع.
                            </p>

                            <a href="{{ route('admin.gym-profile.create') }}" class="mt-5 inline-flex rounded-md bg-mora-accent px-5 py-3 text-sm font-bold text-black transition hover:bg-mora-accent-hover">
                                إضافة البيانات
                            </a>

                        </td>
                    </tr>
                    @endforelse

                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
