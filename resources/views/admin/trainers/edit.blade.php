@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-mora-bg py-10">
    <div class="mx-auto max-w-4xl px-5">

        <div class="mb-8">
            <a href="{{ route('admin.trainers.index') }}" class="text-sm text-mora-muted transition hover:text-mora-accent">
                ← العودة إلى المدربين
            </a>

            <h1 class="mt-4 font-display text-3xl font-bold text-mora-text">
                تعديل بيانات المدرب
            </h1>

            <p class="mt-2 text-sm text-mora-muted">
                تعديل بيانات {{ $trainer->name }}.
            </p>
        </div>

        <div class="rounded-xl border border-mora-border bg-mora-surface p-6 sm:p-8">

            <form method="POST" action="{{ route('admin.trainers.update', $trainer->id) }}" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid gap-6 md:grid-cols-2">

                    <div>
                        <label class="mb-2 block text-sm font-medium text-mora-text">
                            اسم المدرب
                        </label>

                        <input type="text" name="name" value="{{ old('name', $trainer->name) }}" class="w-full rounded-md border border-mora-border bg-mora-card px-4 py-3 text-sm text-mora-text outline-none focus:border-mora-accent">

                        @error('name')
                        <p class="mt-2 text-xs text-red-400">
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-mora-text">
                            المعرّف
                        </label>

                        <input type="text" name="slug" value="{{ old('slug', $trainer->slug) }}" dir="ltr" class="w-full rounded-md border border-mora-border bg-mora-card px-4 py-3 text-left text-sm text-mora-text outline-none focus:border-mora-accent">

                        @error('slug')
                        <p class="mt-2 text-xs text-red-400">
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-mora-text">
                            النوع
                        </label>

                        <select name="gender" class="w-full rounded-md border border-mora-border bg-mora-card px-4 py-3 text-sm text-mora-text outline-none focus:border-mora-accent">
                            <option value="male" @selected(old('gender', $trainer->gender) === 'male')>
                                مدرب
                            </option>

                            <option value="female" @selected(old('gender', $trainer->gender) === 'female')>
                                مدربة
                            </option>
                        </select>

                        @error('gender')
                        <p class="mt-2 text-xs text-red-400">
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-mora-text">
                            التخصص
                        </label>

                        <input type="text" name="specialization" value="{{ old('specialization', $trainer->specialization) }}" class="w-full rounded-md border border-mora-border bg-mora-card px-4 py-3 text-sm text-mora-text outline-none focus:border-mora-accent">

                        @error('specialization')
                        <p class="mt-2 text-xs text-red-400">
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="mb-2 block text-sm font-medium text-mora-text">
                            مسار الصورة داخل مجلد الصور
                        </label>

                        <input type="text" name="image" value="{{ old('image', $trainer->image) }}" dir="ltr" class="w-full rounded-md border border-mora-border bg-mora-card px-4 py-3 text-left text-sm text-mora-text outline-none placeholder:text-mora-muted focus:border-mora-accent">

                        @error('image')
                        <p class="mt-2 text-xs text-red-400">
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="mb-2 block text-sm font-medium text-mora-text">
                            نبذة عن المدرب
                        </label>

                        <textarea name="bio" rows="5" class="w-full resize-none rounded-md border border-mora-border bg-mora-card px-4 py-3 text-sm text-mora-text outline-none focus:border-mora-accent">{{ old('bio', $trainer->bio) }}</textarea>

                        @error('bio')
                        <p class="mt-2 text-xs text-red-400">
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-mora-text">
                            ترتيب العرض
                        </label>

                        <input type="number" name="sort_order" value="{{ old('sort_order', $trainer->sort_order) }}" min="0" max="999" class="w-full rounded-md border border-mora-border bg-mora-card px-4 py-3 text-sm text-mora-text outline-none focus:border-mora-accent">

                        @error('sort_order')
                        <p class="mt-2 text-xs text-red-400">
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                    <div class="flex items-center">
                        <label class="flex cursor-pointer items-center gap-3">
                            <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $trainer->is_active))
                            class="h-5 w-5 rounded border-mora-border bg-mora-card text-mora-accent focus:ring-mora-accent"
                            >

                            <span>
                                <span class="block text-sm font-medium text-mora-text">
                                    مدرب نشط
                                </span>

                                <span class="block text-xs text-mora-muted">
                                    إلغاء التفعيل يمنعه من الاختيار للجلسات الجديدة.
                                </span>
                            </span>
                        </label>
                    </div>

                </div>

                {{-- الجلسات المرتبطة --}}
                <div class="border-t border-mora-border pt-6">
                    <h2 class="text-sm font-semibold text-mora-text">
                        الجلسات المرتبطة بالمدرب
                    </h2>

                    <div class="mt-4 flex flex-wrap gap-2">
                        @forelse($trainer->trainingSessions as $session)
                        <span class="rounded-md border border-mora-border bg-mora-card px-3 py-2 text-xs text-mora-muted">
                            {{ $session->name }}
                        </span>
                        @empty
                        <span class="text-xs text-mora-muted">
                            لا توجد جلسات مرتبطة بهذا المدرب.
                        </span>
                        @endforelse
                    </div>
                </div>

                <div class="flex flex-col-reverse gap-3 border-t border-mora-border pt-6 sm:flex-row">

                    <a href="{{ route('admin.trainers.index') }}" class="rounded-md border border-mora-border px-6 py-3 text-center text-sm font-semibold text-mora-muted transition hover:border-mora-text hover:text-mora-text">
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
