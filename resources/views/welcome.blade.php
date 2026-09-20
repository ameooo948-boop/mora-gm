@extends('layouts.app')

@section('content')
<section class="min-h-screen bg-mora-bg px-5 py-32">
    <div class="mx-auto max-w-3xl text-center">
        <p class="text-xs font-semibold tracking-[0.25em] text-mora-accent">MORA GYM</p>
        <h1 class="mt-4 font-display text-5xl font-bold text-mora-text">أهلًا بك في MORA GYM</h1>
        <p class="mx-auto mt-5 max-w-xl text-sm leading-8 text-mora-muted">مساحة تدريبية تركّز على القوة والاستمرارية والتقدم الحقيقي.</p>
        <a href="{{ route('home') }}" class="mt-8 inline-flex rounded-md bg-mora-accent px-6 py-3 font-semibold text-mora-bg transition hover:bg-mora-accent-hover">العودة إلى الرئيسية</a>
    </div>
</section>
@endsection
