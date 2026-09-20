@extends('layouts.app')

@section('content')

<div class="mx-auto max-w-7xl px-5 py-12">

    {{-- Header --}}
    <div class="mb-8 flex flex-col justify-between gap-5 md:flex-row md:items-center">

        <div>
            <p class="mb-2 text-sm font-medium text-mora-accent">
                لوحة التحكم
            </p>

            <h1 class="font-display text-4xl font-semibold text-mora-text">
                معرض الصور
            </h1>

            <p class="mt-3 text-mora-muted">
                إدارة الصور المعروضة في معرض MORA GYM.
            </p>
        </div>

        <a href="{{ route('admin.gallery.create') }}" class="inline-flex items-center justify-center rounded-md bg-mora-accent px-6 py-3 font-semibold text-mora-bg transition hover:bg-mora-accent-hover">
            + إضافة صورة
        </a>

    </div>

    {{-- Filters --}}
    <div class="mb-6 rounded-xl border border-mora-border bg-mora-surface p-5">

        <form action="{{ route('admin.gallery.index') }}" method="GET" class="grid gap-4 md:grid-cols-3">

            <div>
                <label for="search" class="mb-2 block text-sm text-mora-muted">
                    البحث
                </label>

                <input type="text" id="search" name="search" value="{{ request('search') }}" placeholder="ابحث باسم الصورة أو التصنيف..." class="w-full rounded-md border border-mora-border bg-mora-card px-4 py-3 text-mora-text outline-none focus:border-mora-accent">
            </div>

            <div>
                <label for="category" class="mb-2 block text-sm text-mora-muted">
                    التصنيف
                </label>

                <input type="text" id="category" name="category" value="{{ request('category') }}" placeholder="مثال: الصالة" class="w-full rounded-md border border-mora-border bg-mora-card px-4 py-3 text-mora-text outline-none focus:border-mora-accent">
            </div>

            <div class="flex items-end gap-3">

                <button type="submit" class="rounded-md bg-mora-accent px-6 py-3 font-semibold text-mora-bg transition hover:bg-mora-accent-hover">
                    بحث
                </button>

                <a href="{{ route('admin.gallery.index') }}" class="rounded-md border border-mora-border px-6 py-3 font-semibold text-mora-text transition hover:border-mora-accent hover:text-mora-accent">
                    إعادة ضبط
                </a>

            </div>

        </form>

    </div>

    {{-- Gallery --}}
    @if($items->count())

    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">

        @foreach($items as $item)

        <article class="overflow-hidden rounded-xl border border-mora-border bg-mora-surface">

            {{-- Image --}}
            <div class="relative aspect-[4/3] overflow-hidden bg-mora-card">

                <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}" class="h-full w-full object-cover transition duration-500 hover:scale-105" loading="lazy" onerror="this.classList.add('hidden'); this.nextElementSibling.classList.remove('hidden');">

                <div class="absolute inset-0 hidden items-center justify-center bg-[radial-gradient(circle_at_center,rgba(200,255,0,0.08),transparent_55%)]">
                    <span class="font-display text-7xl font-bold tracking-tight text-white/[0.05]">MORA</span>
                </div>

            </div>

            {{-- Content --}}
            <div class="p-5">

                <div class="mb-3 flex items-start justify-between gap-3">

                    <div>
                        <h2 class="font-display text-xl font-semibold text-mora-text">
                            {{ $item->title }}
                        </h2>

                        <p class="mt-1 text-sm text-mora-accent">
                            {{ $item->category }}
                        </p>
                    </div>

                    @if($item->is_active)
                    <span class="shrink-0 rounded-full bg-mora-accent/10 px-3 py-1 text-xs font-medium text-mora-accent">
                        مفعلة
                    </span>
                    @else
                    <span class="shrink-0 rounded-full bg-white/5 px-3 py-1 text-xs font-medium text-mora-muted">
                        غير مفعلة
                    </span>
                    @endif

                </div>

                @if($item->description)
                <p class="mb-5 line-clamp-3 text-sm leading-7 text-mora-muted">
                    {{ $item->description }}
                </p>
                @endif

                <div class="mb-5 text-xs text-mora-muted">
                    ترتيب الظهور: {{ $item->sort_order }}
                </div>

                <div class="flex gap-2">

                    <a href="{{ route('admin.gallery.edit', $item->id) }}" class="flex-1 rounded-md border border-mora-border px-4 py-2.5 text-center text-sm font-medium text-mora-text transition hover:border-mora-accent hover:text-mora-accent">
                        تعديل
                    </a>

                    <form action="{{ route('admin.gallery.destroy', $item->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف هذه الصورة؟');">
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="rounded-md border border-red-500/30 px-4 py-2.5 text-sm font-medium text-red-400 transition hover:bg-red-500/10">
                            حذف
                        </button>
                    </form>

                </div>

            </div>

        </article>

        @endforeach

    </div>

    <div class="mt-8">
        {{ $items->links() }}
    </div>

    @else

    <div class="rounded-xl border border-mora-border bg-mora-surface px-6 py-16 text-center">

        <h2 class="font-display text-2xl font-semibold text-mora-text">
            لا توجد صور
        </h2>

        <p class="mt-3 text-mora-muted">
            لم يتم العثور على أي صور مطابقة للبحث.
        </p>

        <a href="{{ route('admin.gallery.create') }}" class="mt-6 inline-flex rounded-md bg-mora-accent px-6 py-3 font-semibold text-mora-bg transition hover:bg-mora-accent-hover">
            إضافة أول صورة
        </a>

    </div>

    @endif

</div>

@endsection
