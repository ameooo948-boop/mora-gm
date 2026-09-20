@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-5xl px-5 py-10">

    <div class="mb-8">
        <a href="{{ route('admin.gym-profile.index') }}" class="text-sm text-mora-muted transition hover:text-mora-accent">
            ← العودة إلى إعدادات الجيم
        </a>

        <h1 class="mt-5 font-display text-3xl font-bold text-white">
            إضافة بيانات الجيم
        </h1>

        <p class="mt-2 text-sm text-mora-muted">
            أدخل البيانات الأساسية التي ستظهر في الموقع.
        </p>
    </div>

    <form method="POST" action="{{ route('admin.gym-profile.store') }}" class="space-y-6">
        @csrf

        @include('admin.gym-profile._form')

        <div class="flex flex-col gap-3 sm:flex-row">
            <button type="submit" class="rounded-md bg-mora-accent px-6 py-3 text-sm font-bold text-black transition hover:bg-mora-accent-hover">
                حفظ البيانات
            </button>

            <a href="{{ route('admin.gym-profile.index') }}" class="rounded-md border border-mora-border px-6 py-3 text-center text-sm font-semibold text-white transition hover:border-mora-accent">
                إلغاء
            </a>
        </div>
    </form>

</div>
@endsection
