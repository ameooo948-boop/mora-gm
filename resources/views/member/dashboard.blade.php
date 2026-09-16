@extends('layouts.app')

@section('content')

<section class="min-h-[70vh] py-20">
    <div class="mx-auto max-w-7xl px-5 lg:px-8">

        <p class="text-xs font-bold uppercase tracking-[0.25em] text-mora-accent">
            منطقة الأعضاء
        </p>

        <h1 class="mt-3 font-display text-5xl font-semibold uppercase">
            مرحبًا، {{ auth()->user()->name }}.
        </h1>

        <p class="mt-4 text-sm text-mora-muted">
            لوحة عضويتك في MORA قيد التجهيز.
        </p>

    </div>
</section>

@endsection
