@csrf

@if($mode === 'edit')
@method('PUT')
@endif

<div class="space-y-6">

    {{-- العنوان --}}
    <div>
        <label for="title" class="mb-2 block text-sm font-medium text-mora-text">
            عنوان الصورة
        </label>

        <input type="text" id="title" name="title" value="{{ old('title', $item->title ?? '') }}" required class="w-full rounded-md border border-mora-border bg-mora-card px-4 py-3 text-mora-text outline-none transition focus:border-mora-accent" placeholder="مثال: صالة MORA GYM">

        @error('title')
        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
        @enderror
    </div>

    {{-- التصنيف --}}
    <div>
        <label for="category" class="mb-2 block text-sm font-medium text-mora-text">
            التصنيف
        </label>

        <input type="text" id="category" name="category" value="{{ old('category', $item->category ?? '') }}" required class="w-full rounded-md border border-mora-border bg-mora-card px-4 py-3 text-mora-text outline-none transition focus:border-mora-accent" placeholder="مثال: صالة الألعاب">

        @error('category')
        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
        @enderror
    </div>

    {{-- مسار الصورة --}}
    <div>
        <label for="image" class="mb-2 block text-sm font-medium text-mora-text">
            مسار الصورة
        </label>

        <input type="text" id="image" name="image" value="{{ old('image', $item->image ?? '') }}" required class="w-full rounded-md border border-mora-border bg-mora-card px-4 py-3 text-mora-text outline-none transition focus:border-mora-accent" placeholder="مثال: gallery/gym-1.webp">

        <p class="mt-2 text-xs text-mora-muted">
            اكتب مسار الصورة الموجود داخل مجلد الصور داخل public.
        </p>

        @error('image')
        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
        @enderror
    </div>

    {{-- الوصف --}}
    <div>
        <label for="description" class="mb-2 block text-sm font-medium text-mora-text">
            الوصف
        </label>

        <textarea id="description" name="description" rows="5" class="w-full rounded-md border border-mora-border bg-mora-card px-4 py-3 text-mora-text outline-none transition focus:border-mora-accent" placeholder="اكتب وصفًا مختصرًا للصورة...">{{ old('description', $item->description ?? '') }}</textarea>

        @error('description')
        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
        @enderror
    </div>

    {{-- الترتيب --}}
    <div>
        <label for="sort_order" class="mb-2 block text-sm font-medium text-mora-text">
            ترتيب الظهور
        </label>

        <input type="number" id="sort_order" name="sort_order" min="0" max="999" value="{{ old('sort_order', $item->sort_order ?? 0) }}" class="w-full rounded-md border border-mora-border bg-mora-card px-4 py-3 text-mora-text outline-none transition focus:border-mora-accent">

        @error('sort_order')
        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
        @enderror
    </div>

    {{-- الحالة --}}
    <div class="flex items-center gap-3">
        <input type="hidden" name="is_active" value="0">

        <input type="checkbox" id="is_active" name="is_active" value="1" @checked(old('is_active', $item->is_active ?? true))
        class="h-5 w-5 rounded border-mora-border bg-mora-card text-mora-accent focus:ring-mora-accent"
        >

        <label for="is_active" class="text-sm text-mora-text">
            الصورة مفعلة وتظهر في المعرض
        </label>
    </div>

    <div class="flex flex-wrap gap-3 border-t border-mora-border pt-6">

        <button type="submit" class="rounded-md bg-mora-accent px-6 py-3 font-semibold text-mora-bg transition hover:bg-mora-accent-hover">
            {{ $mode === 'edit' ? 'حفظ التعديلات' : 'إضافة الصورة' }}
        </button>

        <a href="{{ route('admin.gallery.index') }}" class="rounded-md border border-mora-border px-6 py-3 font-semibold text-mora-text transition hover:border-mora-accent hover:text-mora-accent">
            إلغاء
        </a>

    </div>

</div>
