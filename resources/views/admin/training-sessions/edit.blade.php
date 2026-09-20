@extends('layouts.app')

@section('content')

@php
$currentTrainerId = $trainingSession->trainers->first()?->id;
@endphp

<div class="min-h-screen bg-mora-bg py-10">
    <div class="mx-auto max-w-4xl px-5">

        <div class="mb-8">
            <a href="{{ route('admin.training-sessions.index') }}" class="text-sm text-mora-muted transition hover:text-mora-accent">
                ← العودة إلى الجلسات
            </a>

            <h1 class="mt-4 font-display text-3xl font-bold text-mora-text">
                تعديل الجلسة التدريبية
            </h1>

            <p class="mt-2 text-sm text-mora-muted">
                تعديل بيانات جلسة {{ $trainingSession->name }}.
            </p>
        </div>

        <div class="rounded-xl border border-mora-border bg-mora-surface p-6 sm:p-8">

            <form method="POST" action="{{ route('admin.training-sessions.update', $trainingSession->id) }}" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid gap-6 md:grid-cols-2">

                    <div class="md:col-span-2">
                        <label class="mb-2 block text-sm font-medium text-mora-text">
                            اسم الجلسة
                        </label>

                        <input type="text" name="name" value="{{ old('name', $trainingSession->name) }}" class="w-full rounded-md border border-mora-border bg-mora-card px-4 py-3 text-sm text-mora-text outline-none focus:border-mora-accent">

                        @error('name')
                        <p class="mt-2 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div x-data="{
        audience: '{{ old('audience', $trainingSession->audience) }}'
    }" class="md:col-span-2 grid gap-6 md:grid-cols-2">

                        <div>
                            <label class="mb-2 block text-sm font-medium text-mora-text">
                                الفئة
                            </label>

                            <select name="audience" x-model="audience" class="w-full rounded-md border border-mora-border bg-mora-card px-4 py-3 text-sm text-mora-text outline-none focus:border-mora-accent">
                                <option value="Women">
                                    النساء
                                </option>

                                <option value="Men">
                                    الرجال
                                </option>
                            </select>

                            @error('audience')
                            <p class="mt-2 text-xs text-red-400">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-medium text-mora-text">
                                المدرب
                            </label>

                            <select name="trainer_id" class="w-full rounded-md border border-mora-border bg-mora-card px-4 py-3 text-sm text-mora-text outline-none focus:border-mora-accent">
                                <option value="">اختر المدرب</option>

                                <template x-if="audience === 'Men'">
                                    <option value="{{ $maleTrainers->first()?->id }}" @selected(old('trainer_id', $currentTrainerId)==$maleTrainers->first()?->id)
                                        >
                                        {{ $maleTrainers->first()?->name ?? 'لا يوجد مدرب رجال' }}
                                    </option>
                                </template>

                                <template x-if="audience === 'Women'">
                                    <option value="{{ $femaleTrainers->first()?->id }}" @selected(old('trainer_id', $currentTrainerId)==$femaleTrainers->first()?->id)
                                        >
                                        {{ $femaleTrainers->first()?->name ?? 'لا توجد مدربة نساء' }}
                                    </option>
                                </template>
                            </select>

                            @error('trainer_id')
                            <p class="mt-2 text-xs text-red-400">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>

                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-mora-text">
                            ترتيب العرض
                        </label>

                        <input type="number" name="sort_order" min="0" max="999" value="{{ old('sort_order', $trainingSession->sort_order) }}" class="w-full rounded-md border border-mora-border bg-mora-card px-4 py-3 text-sm text-mora-text outline-none focus:border-mora-accent">

                        @error('sort_order')
                        <p class="mt-2 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-mora-text">
                            وقت البداية
                        </label>

                        <input type="time" name="starts_at" value="{{ old('starts_at', $trainingSession->starts_at ? \Illuminate\Support\Carbon::parse($trainingSession->starts_at)->format('H:i') : '') }}" class="w-full rounded-md border border-mora-border bg-mora-card px-4 py-3 text-sm text-mora-text outline-none focus:border-mora-accent">

                        @error('starts_at')
                        <p class="mt-2 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-mora-text">
                            وقت النهاية
                        </label>

                        <input type="time" name="ends_at" value="{{ old('ends_at', $trainingSession->ends_at ? \Illuminate\Support\Carbon::parse($trainingSession->ends_at)->format('H:i') : '') }}" class="w-full rounded-md border border-mora-border bg-mora-card px-4 py-3 text-sm text-mora-text outline-none focus:border-mora-accent">

                        @error('ends_at')
                        <p class="mt-2 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="mb-2 block text-sm font-medium text-mora-text">
                            الوصف
                        </label>

                        <textarea name="description" rows="5" class="w-full resize-none rounded-md border border-mora-border bg-mora-card px-4 py-3 text-sm text-mora-text outline-none focus:border-mora-accent">{{ old('description', $trainingSession->description) }}</textarea>

                        @error('description')
                        <p class="mt-2 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="flex cursor-pointer items-center gap-3">
                            <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $trainingSession->is_active))
                            class="h-5 w-5 rounded border-mora-border bg-mora-card text-mora-accent focus:ring-mora-accent"
                            >

                            <span>
                                <span class="block text-sm font-medium text-mora-text">
                                    جلسة نشطة
                                </span>

                                <span class="block text-xs text-mora-muted">
                                    إلغاء التفعيل يخفي الجلسة من الجلسات النشطة بالموقع.
                                </span>
                            </span>
                        </label>
                    </div>

                </div>

                <div class="flex flex-col-reverse gap-3 border-t border-mora-border pt-6 sm:flex-row">

                    <a href="{{ route('admin.training-sessions.index') }}" class="rounded-md border border-mora-border px-6 py-3 text-center text-sm font-semibold text-mora-muted transition hover:border-mora-text hover:text-mora-text">
                        إلغاء
                    </a>

                    <button type="submit" class="rounded-md bg-mora-accent px-6 py-3 text-sm font-bold text-mora-bg transition hover:bg-mora-accent-hover">
                        حفظ التعديلات
                    </button>

                </div>

            </form>
        </div>

    </div>
</div>
@endsection
