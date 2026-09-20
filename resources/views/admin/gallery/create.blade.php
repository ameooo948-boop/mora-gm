@extends('layouts.app')

@section('content')

<div class="mx-auto max-w-4xl px-5 py-12">

    <div class="mb-8">
        <p class="mb-2 text-sm font-medium text-mora-accent">
            معرض الصور
        </p>

        <h1 class="font-display text-4xl font-semibold text-mora-text">
            إضافة صورة جديدة
        </h1>

        <p class="mt-3 text-mora-muted">
            أضف صورة جديدة إلى معرض MORA GYM.
        </p>
    </div>

    <div class="rounded-xl border border-mora-border bg-mora-surface p-6 md:p-8">

        <form action="{{ route('admin.gallery.store') }}" method="POST">
            @include('admin.gallery._form', [
            'mode' => 'create',
            'item' => null,
            ])
        </form>

    </div>

</div>

@endsection
