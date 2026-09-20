@extends('layouts.app')

@section('content')

<div class="mx-auto max-w-4xl px-5 py-12">

    <div class="mb-8">
        <p class="mb-2 text-sm font-medium text-mora-accent">
            معرض الصور
        </p>

        <h1 class="font-display text-4xl font-semibold text-mora-text">
            تعديل الصورة
        </h1>

        <p class="mt-3 text-mora-muted">
            تعديل بيانات الصورة ومعلومات ظهورها في المعرض.
        </p>
    </div>

    <div class="rounded-xl border border-mora-border bg-mora-surface p-6 md:p-8">

        <form action="{{ route('admin.gallery.update', $item->id) }}" method="POST">
            @include('admin.gallery._form', [
            'mode' => 'edit',
            'item' => $item,
            ])
        </form>

    </div>

</div>

@endsection
