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
    
    {{-- الصورة --}}
    <div>
        <label for="image" class="mb-2 block text-sm font-medium text-mora-text">
            {{ $mode === 'edit' ? 'تغيير الصورة' : 'الصورة' }}
        </label>

        <input type="file" id="image" name="image" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp" @required($mode==='create' ) class="block w-full cursor-pointer rounded-md border border-mora-border bg-mora-card text-sm text-mora-muted file:mr-4 file:border-0 file:bg-mora-accent file:px-5 file:py-3 file:font-semibold file:text-mora-bg hover:file:bg-mora-accent-hover">

        <p class="mt-2 text-xs text-mora-muted">
            الصيغ المسموحة: JPG, JPEG, PNG, WEBP — الحد الأقصى 5 ميجابايت.
        </p>

        @if($mode === 'edit' && !empty($item?->image))
        <div class="mt-4">
            <p class="mb-2 text-sm text-mora-muted">
                الصورة الحالية
            </p>

            <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}" class="h-40 w-full rounded-lg object-cover md:w-64">
        </div>
        @endif

        @error('image')
        <p class="mt-2 text-sm text-red-400">
            {{ $message }}
        </p>
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
