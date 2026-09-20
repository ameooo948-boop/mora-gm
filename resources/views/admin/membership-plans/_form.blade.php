<div class="rounded-lg border border-mora-border bg-mora-card p-6">

    <div class="grid gap-6 md:grid-cols-2">

        {{-- الاسم --}}
        <div>
            <label class="mb-2 block text-sm font-semibold text-white">
                اسم الخطة
            </label>

            <input type="text" name="name" value="{{ old('name', $membershipPlan->name ?? '') }}" placeholder="مثال: الاشتراك الشهري" class="w-full rounded-md border border-mora-border bg-mora-surface px-4 py-3 text-white outline-none placeholder:text-mora-muted focus:border-mora-accent">

            @error('name')
            <p class="mt-2 text-xs text-red-400">{{ $message }}</p>
            @enderror
        </div>

        {{-- Slug --}}
        <div>
            <label class="mb-2 block text-sm font-semibold text-white">
                المعرّف
            </label>

            <input type="text" name="slug" dir="ltr" value="{{ old('slug', $membershipPlan->slug ?? '') }}" placeholder="monthly" class="w-full rounded-md border border-mora-border bg-mora-surface px-4 py-3 text-left text-white outline-none placeholder:text-mora-muted focus:border-mora-accent">

            @error('slug')
            <p class="mt-2 text-xs text-red-400">{{ $message }}</p>
            @enderror
        </div>

        {{-- المدة --}}
        <div>
            <label class="mb-2 block text-sm font-semibold text-white">
                مدة الاشتراك بالأيام
            </label>

            <input type="number" name="duration_days" min="1" value="{{ old('duration_days', $membershipPlan->duration_days ?? '') }}" placeholder="30" class="w-full rounded-md border border-mora-border bg-mora-surface px-4 py-3 text-white outline-none placeholder:text-mora-muted focus:border-mora-accent">

            @error('duration_days')
            <p class="mt-2 text-xs text-red-400">{{ $message }}</p>
            @enderror
        </div>

        {{-- السعر --}}
        <div>
            <label class="mb-2 block text-sm font-semibold text-white">
                السعر بالجنيه المصري
            </label>

            <input type="number" name="price" min="0" step="0.01" value="{{ old('price', $membershipPlan->price ?? '') }}" placeholder="300" class="w-full rounded-md border border-mora-border bg-mora-surface px-4 py-3 text-white outline-none placeholder:text-mora-muted focus:border-mora-accent">

            @error('price')
            <p class="mt-2 text-xs text-red-400">{{ $message }}</p>
            @enderror
        </div>

        {{-- الترتيب --}}
        <div>
            <label class="mb-2 block text-sm font-semibold text-white">
                ترتيب الظهور
            </label>

            <input type="number" name="sort_order" min="0" value="{{ old('sort_order', $membershipPlan->sort_order ?? 0) }}" class="w-full rounded-md border border-mora-border bg-mora-surface px-4 py-3 text-white outline-none focus:border-mora-accent">

            @error('sort_order')
            <p class="mt-2 text-xs text-red-400">{{ $message }}</p>
            @enderror
        </div>

    </div>

    {{-- الوصف المختصر --}}
    <div class="mt-6">
        <label class="mb-2 block text-sm font-semibold text-white">
            الوصف المختصر
        </label>

        <input type="text" name="short_description" value="{{ old('short_description', $membershipPlan->short_description ?? '') }}" placeholder="وصف مختصر يظهر مع الخطة" class="w-full rounded-md border border-mora-border bg-mora-surface px-4 py-3 text-white outline-none placeholder:text-mora-muted focus:border-mora-accent">

        @error('short_description')
        <p class="mt-2 text-xs text-red-400">{{ $message }}</p>
        @enderror
    </div>

    {{-- الوصف --}}
    <div class="mt-6">
        <label class="mb-2 block text-sm font-semibold text-white">
            الوصف الكامل
        </label>

        <textarea name="description" rows="5" placeholder="اكتب تفاصيل الخطة..." class="w-full rounded-md border border-mora-border bg-mora-surface px-4 py-3 text-white outline-none placeholder:text-mora-muted focus:border-mora-accent">{{ old('description', $membershipPlan->description ?? '') }}</textarea>

        @error('description')
        <p class="mt-2 text-xs text-red-400">{{ $message }}</p>
        @enderror
    </div>

    {{-- المميزات --}}
    <div class="mt-6">
        <div class="mb-3 flex items-center justify-between">
            <label class="text-sm font-semibold text-white">
                مميزات الخطة
            </label>

            <button type="button" @click="addFeature()" class="text-sm font-semibold text-mora-accent hover:text-mora-accent-hover">
                + إضافة ميزة
            </button>
        </div>

        <div class="space-y-3">
            <template x-for="(feature, index) in features" :key="index">
                <div class="flex gap-2">
                    <input type="text" name="features[]" x-model="features[index]" placeholder="مثال: دخول الجيم طوال مدة الاشتراك" class="flex-1 rounded-md border border-mora-border bg-mora-surface px-4 py-3 text-sm text-white outline-none placeholder:text-mora-muted focus:border-mora-accent">

                    <button type="button" @click="removeFeature(index)" class="rounded-md border border-red-500/30 px-4 text-red-400 transition hover:bg-red-500/10">
                        حذف
                    </button>
                </div>
            </template>
        </div>

        @error('features')
        <p class="mt-2 text-xs text-red-400">{{ $message }}</p>
        @enderror

        @error('features.*')
        <p class="mt-2 text-xs text-red-400">{{ $message }}</p>
        @enderror
    </div>

    {{-- الخيارات --}}
    <div class="mt-6 grid gap-4 sm:grid-cols-2">

        <label class="flex cursor-pointer items-center gap-3 rounded-md border border-mora-border bg-mora-surface p-4">
            <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $membershipPlan->is_featured ?? false))
            class="h-4 w-4 accent-lime-400"
            >

            <span>
                <span class="block text-sm font-semibold text-white">
                    خطة مميزة
                </span>

                <span class="mt-1 block text-xs text-mora-muted">
                    تظهر بشكل بارز في صفحة العضويات.
                </span>
            </span>
        </label>

        <label class="flex cursor-pointer items-center gap-3 rounded-md border border-mora-border bg-mora-surface p-4">
            <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $membershipPlan->is_active ?? true))
            class="h-4 w-4 accent-lime-400"
            >

            <span>
                <span class="block text-sm font-semibold text-white">
                    الخطة مفعلة
                </span>

                <span class="mt-1 block text-xs text-mora-muted">
                    الخطة متاحة للاستخدام في الموقع.
                </span>
            </span>
        </label>

    </div>

</div>
