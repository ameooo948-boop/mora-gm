@extends('layouts.app')

@section('content')

<section class="min-h-screen bg-mora-bg py-24">
    <div class="mx-auto max-w-3xl px-5">

        <div class="mb-10">
            <p class="mb-3 text-xs font-semibold uppercase tracking-[0.25em] text-mora-accent">
                MORA GYM
            </p>

            <h1 class="font-display text-4xl font-bold text-mora-text">
                الملف الشخصي
            </h1>

            <p class="mt-3 text-sm text-mora-muted">
                حدّث بيانات حسابك الشخصية.
            </p>
        </div>

        <form method="POST" action="{{ route('member.profile.update') }}" class="border border-mora-border bg-mora-card p-6 md:p-8">
            @csrf
            @method('PUT')

            <div class="space-y-6">

                <div>
                    <label for="name" class="mb-2 block text-sm font-medium text-mora-text">
                        الاسم
                    </label>

                    <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required class="w-full rounded-md border border-mora-border bg-mora-surface px-4 py-3 text-sm text-mora-text outline-none transition focus:border-mora-accent">

                    @error('name')
                    <p class="mt-2 text-xs text-red-400">
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="mb-2 block text-sm font-medium text-mora-text">
                        البريد الإلكتروني
                    </label>

                    <input id="email" type="email" value="{{ $user->email }}" disabled class="w-full rounded-md border border-mora-border bg-mora-surface px-4 py-3 text-sm text-mora-muted">

                    <p class="mt-2 text-xs text-mora-muted">
                        لا يمكن تعديل البريد الإلكتروني من هذه الصفحة.
                    </p>
                </div>

                <div>
                    <label for="phone" class="mb-2 block text-sm font-medium text-mora-text">
                        رقم الهاتف
                    </label>

                    <input id="phone" name="phone" type="text" value="{{ old('phone', $user->phone) }}" class="w-full rounded-md border border-mora-border bg-mora-surface px-4 py-3 text-sm text-mora-text outline-none transition focus:border-mora-accent">

                    @error('phone')
                    <p class="mt-2 text-xs text-red-400">
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-mora-text">
                        النوع
                    </label>

                    <div class="w-full rounded-md border border-mora-border bg-mora-surface px-4 py-3 text-sm text-mora-muted">
                        {{ $user->gender?->label() ?? 'غير محدد' }}
                    </div>

                    <p class="mt-2 text-xs leading-6 text-mora-muted">
                        لا يمكن تغيير النوع من الملف الشخصي، ويُستخدم لتحديد الجلسات المناسبة لك.
                    </p>
                </div>

            </div>

            <div class="mt-8 flex justify-end">
                <button type="submit" class="rounded-md bg-mora-accent px-7 py-3 text-sm font-bold text-mora-bg transition hover:bg-mora-accent-hover">
                    حفظ التغييرات
                </button>
            </div>

        </form>

    </div>
</section>

@endsection
