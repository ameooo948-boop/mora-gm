<div class="space-y-6">

    {{-- البيانات الأساسية --}}
    <div class="rounded-lg border border-mora-border bg-mora-card p-6">

        <h2 class="font-display text-xl font-bold text-white">
            البيانات الأساسية
        </h2>

        <div class="mt-6 grid gap-6 md:grid-cols-2">

            <div>
                <label class="mb-2 block text-sm font-semibold text-white">
                    اسم الجيم
                </label>

                <input type="text" name="name" value="{{ old('name', $gymProfile->name ?? '') }}" placeholder="MORA GYM" class="w-full rounded-md border border-mora-border bg-mora-surface px-4 py-3 text-white outline-none placeholder:text-mora-muted focus:border-mora-accent">

                @error('name')
                <p class="mt-2 text-xs text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold text-white">
                    العنوان المختصر
                </label>

                <input type="text" name="eyebrow" value="{{ old('eyebrow', $gymProfile->eyebrow ?? '') }}" placeholder="جيمك لبداية أقوى" class="w-full rounded-md border border-mora-border bg-mora-surface px-4 py-3 text-white outline-none placeholder:text-mora-muted focus:border-mora-accent">

                @error('eyebrow')
                <p class="mt-2 text-xs text-red-400">{{ $message }}</p>
                @enderror
            </div>

        </div>

        <div class="mt-6 grid gap-6 md:grid-cols-3">

            <div>
                <label class="mb-2 block text-sm font-semibold text-white">
                    مساحة الجيم بالمتر
                </label>

                <input type="number" name="space_size" min="1" value="{{ old('space_size', $gymProfile->space_size ?? 150) }}" class="w-full rounded-md border border-mora-border bg-mora-surface px-4 py-3 text-white outline-none focus:border-mora-accent">

                @error('space_size')
                <p class="mt-2 text-xs text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold text-white">
                    عدد المدربين
                </label>

                <input type="number" name="trainer_count" min="0" value="{{ old('trainer_count', $gymProfile->trainer_count ?? 2) }}" class="w-full rounded-md border border-mora-border bg-mora-surface px-4 py-3 text-white outline-none focus:border-mora-accent">

                @error('trainer_count')
                <p class="mt-2 text-xs text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold text-white">
                    مسار صورة About
                </label>

                <input type="text" name="image" dir="ltr" value="{{ old('image', $gymProfile->image ?? '') }}" placeholder="about/mora-gym.webp" class="w-full rounded-md border border-mora-border bg-mora-surface px-4 py-3 text-left text-white outline-none placeholder:text-mora-muted focus:border-mora-accent">

                @error('image')
                <p class="mt-2 text-xs text-red-400">{{ $message }}</p>
                @enderror
            </div>

        </div>

    </div>

    {{-- نبذة الجيم --}}
    <div class="rounded-lg border border-mora-border bg-mora-card p-6">

        <h2 class="font-display text-xl font-bold text-white">
            نبذة عن الجيم
        </h2>

        <div class="mt-6">

            <label class="mb-2 block text-sm font-semibold text-white">
                عنوان النبذة
            </label>

            <input type="text" name="about_title" value="{{ old('about_title', $gymProfile->about_title ?? '') }}" placeholder="عن MORA GYM" class="w-full rounded-md border border-mora-border bg-mora-surface px-4 py-3 text-white outline-none placeholder:text-mora-muted focus:border-mora-accent">

            @error('about_title')
            <p class="mt-2 text-xs text-red-400">{{ $message }}</p>
            @enderror

        </div>

        <div class="mt-6">

            <label class="mb-2 block text-sm font-semibold text-white">
                وصف الجيم
            </label>

            <textarea name="about_description" rows="6" placeholder="اكتب نبذة احترافية عن MORA GYM..." class="w-full rounded-md border border-mora-border bg-mora-surface px-4 py-3 text-white outline-none placeholder:text-mora-muted focus:border-mora-accent">{{ old('about_description', $gymProfile->about_description ?? '') }}</textarea>

            @error('about_description')
            <p class="mt-2 text-xs text-red-400">{{ $message }}</p>
            @enderror

        </div>

    </div>

    {{-- الرسالة والرؤية --}}
    <div class="grid gap-6 md:grid-cols-2">

        <div class="rounded-lg border border-mora-border bg-mora-card p-6">

            <h2 class="font-display text-xl font-bold text-white">
                رسالة الجيم
            </h2>

            <div class="mt-6">
                <label class="mb-2 block text-sm font-semibold text-white">
                    العنوان
                </label>

                <input type="text" name="mission_title" value="{{ old('mission_title', $gymProfile->mission_title ?? '') }}" placeholder="رسالتنا" class="w-full rounded-md border border-mora-border bg-mora-surface px-4 py-3 text-white outline-none placeholder:text-mora-muted focus:border-mora-accent">

                @error('mission_title')
                <p class="mt-2 text-xs text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-5">
                <label class="mb-2 block text-sm font-semibold text-white">
                    الرسالة
                </label>

                <textarea name="mission" rows="7" placeholder="اكتب رسالة الجيم..." class="w-full rounded-md border border-mora-border bg-mora-surface px-4 py-3 text-white outline-none placeholder:text-mora-muted focus:border-mora-accent">{{ old('mission', $gymProfile->mission ?? '') }}</textarea>

                @error('mission')
                <p class="mt-2 text-xs text-red-400">{{ $message }}</p>
                @enderror
            </div>

        </div>

        <div class="rounded-lg border border-mora-border bg-mora-card p-6">

            <h2 class="font-display text-xl font-bold text-white">
                رؤية الجيم
            </h2>

            <div class="mt-6">
                <label class="mb-2 block text-sm font-semibold text-white">
                    العنوان
                </label>

                <input type="text" name="vision_title" value="{{ old('vision_title', $gymProfile->vision_title ?? '') }}" placeholder="رؤيتنا" class="w-full rounded-md border border-mora-border bg-mora-surface px-4 py-3 text-white outline-none placeholder:text-mora-muted focus:border-mora-accent">

                @error('vision_title')
                <p class="mt-2 text-xs text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-5">
                <label class="mb-2 block text-sm font-semibold text-white">
                    الرؤية
                </label>

                <textarea name="vision" rows="7" placeholder="اكتب رؤية الجيم..." class="w-full rounded-md border border-mora-border bg-mora-surface px-4 py-3 text-white outline-none placeholder:text-mora-muted focus:border-mora-accent">{{ old('vision', $gymProfile->vision ?? '') }}</textarea>

                @error('vision')
                <p class="mt-2 text-xs text-red-400">{{ $message }}</p>
                @enderror
            </div>

        </div>

    </div>

    {{-- بيانات التواصل --}}
    <div class="rounded-lg border border-mora-border bg-mora-card p-6">

        <h2 class="font-display text-xl font-bold text-white">
            بيانات التواصل والدفع
        </h2>

        <div class="mt-6 grid gap-6 md:grid-cols-2">

            <div>
                <label class="mb-2 block text-sm font-semibold text-white">
                    رقم الهاتف
                </label>

                <input type="text" name="phone" dir="ltr" value="{{ old('phone', $gymProfile->phone ?? '') }}" placeholder="01xxxxxxxxx" class="w-full rounded-md border border-mora-border bg-mora-surface px-4 py-3 text-left text-white outline-none placeholder:text-mora-muted focus:border-mora-accent">

                @error('phone')
                <p class="mt-2 text-xs text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold text-white">
                    رقم واتساب
                </label>

                <input type="text" name="whatsapp" dir="ltr" value="{{ old('whatsapp', $gymProfile->whatsapp ?? '') }}" placeholder="01xxxxxxxxx" class="w-full rounded-md border border-mora-border bg-mora-surface px-4 py-3 text-left text-white outline-none placeholder:text-mora-muted focus:border-mora-accent">

                @error('whatsapp')
                <p class="mt-2 text-xs text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold text-white">
                    البريد الإلكتروني
                </label>

                <input type="email" name="email" dir="ltr" value="{{ old('email', $gymProfile->email ?? '') }}" placeholder="info@moragym.com" class="w-full rounded-md border border-mora-border bg-mora-surface px-4 py-3 text-left text-white outline-none placeholder:text-mora-muted focus:border-mora-accent">

                @error('email')
                <p class="mt-2 text-xs text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold text-white">
                    Instagram
                </label>

                <input type="url" name="instagram_url" dir="ltr" value="{{ old('instagram_url', $gymProfile->instagram_url ?? '') }}" placeholder="https://instagram.com/..." class="w-full rounded-md border border-mora-border bg-mora-surface px-4 py-3 text-left text-white outline-none placeholder:text-mora-muted focus:border-mora-accent">

                @error('instagram_url')
                <p class="mt-2 text-xs text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold text-white">
                    رقم Vodafone Cash
                </label>

                <input type="text" name="vodafone_cash" dir="ltr" value="{{ old('vodafone_cash', $gymProfile->vodafone_cash ?? '') }}" placeholder="01xxxxxxxxx" class="w-full rounded-md border border-mora-border bg-mora-surface px-4 py-3 text-left text-white outline-none placeholder:text-mora-muted focus:border-mora-accent">

                @error('vodafone_cash')
                <p class="mt-2 text-xs text-red-400">{{ $message }}</p>
                @enderror
            </div>

        </div>

        <div class="mt-6">

            <label class="mb-2 block text-sm font-semibold text-white">
                العنوان
            </label>

            <textarea name="address" rows="3" placeholder="عنوان MORA GYM..." class="w-full rounded-md border border-mora-border bg-mora-surface px-4 py-3 text-white outline-none placeholder:text-mora-muted focus:border-mora-accent">{{ old('address', $gymProfile->address ?? '') }}</textarea>

            @error('address')
            <p class="mt-2 text-xs text-red-400">{{ $message }}</p>
            @enderror

        </div>

    </div>

    {{-- الحالة --}}
    <div class="rounded-lg border border-mora-border bg-mora-card p-6">

        <label class="flex cursor-pointer items-center gap-3">

            <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $gymProfile->is_active ?? true))
            class="h-4 w-4 accent-lime-400"
            >

            <span>
                <span class="block text-sm font-semibold text-white">
                    تفعيل بيانات الجيم
                </span>

                <span class="mt-1 block text-xs text-mora-muted">
                    سيتم استخدام هذه البيانات في الأجزاء العامة من الموقع.
                </span>
            </span>

        </label>

    </div>

</div>
