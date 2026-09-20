@extends('layouts.error')

@section('content')
<div class="mt-12 rounded-2xl border border-mora-border bg-mora-card px-6 py-12 sm:px-10">
    <p class="font-display text-7xl font-bold text-mora-accent sm:text-8xl">419</p>
    <h1 class="mt-6 font-display text-3xl font-semibold text-mora-text sm:text-4xl">
        انتهت الجلسة.
    </h1>
    <p class="mx-auto mt-4 max-w-xl text-sm leading-7 text-mora-muted">
        انتهت صلاحية الطلب، يرجى تحديث الصفحة والمحاولة مرة أخرى.
    </p>
    <a href="{{ route('home') }}" class="mt-8 inline-flex rounded-md bg-mora-accent px-6 py-3 text-sm font-semibold text-mora-bg transition hover:bg-mora-accent-hover">
        العودة إلى الرئيسية
    </a>
</div>
@endsection
