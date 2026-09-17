@extends('layouts.auth')

@section('content')

<div class="flex min-h-screen items-center justify-center px-5 py-12 sm:px-8">

    <div class="w-full max-w-lg">

        <div class="mb-10 text-center">
            <a href="{{ route('home') }}" class="font-display text-3xl font-bold tracking-[0.12em]">
                MORA
            </a>

            <p class="mt-8 text-xs font-bold uppercase tracking-[0.25em] text-mora-accent">
                ابدأ رحلتك.
            </p>

            <h1 class="mt-3 font-display text-4xl font-semibold uppercase">
                أنشئ حسابك.
            </h1>

            <p class="mt-3 text-sm text-mora-muted">
                انضم إلى MORA وابدأ في بناء عادات أفضل.
            </p>
        </div>


        <div class="rounded-[10px] border border-mora-border bg-mora-card p-6 sm:p-8">

            <form action="{{ route('register.store') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label for="name" class="mb-2 block text-xs font-bold uppercase tracking-[0.15em]">
                        الاسم الكامل
                    </label>

                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" class="w-full rounded-[6px] border border-mora-border bg-mora-surface px-4 py-3.5 text-sm outline-none transition focus:border-mora-accent" placeholder="Your full name">

                    @error('name')
                    <p class="mt-2 text-xs text-red-400">
                        {{ $message }}
                    </p>
                    @enderror
                </div>


                <div class="grid gap-5 sm:grid-cols-2">

                    <div>
                        <label for="email" class="mb-2 block text-xs font-bold uppercase tracking-[0.15em]">
                            البريد الإلكتروني
                        </label>

                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" class="w-full rounded-[6px] border border-mora-border bg-mora-surface px-4 py-3.5 text-sm outline-none transition focus:border-mora-accent" placeholder="you@example.com">

                        @error('email')
                        <p class="mt-2 text-xs text-red-400">
                            {{ $message }}
                        </p>
                        @enderror
                    </div>


                    <div>
                        <label for="phone" class="mb-2 block text-xs font-bold uppercase tracking-[0.15em]">
                            رقم الهاتف
                        </label>

                        <input id="phone" type="tel" name="phone" value="{{ old('phone') }}" autocomplete="tel" class="w-full rounded-[6px] border border-mora-border bg-mora-surface px-4 py-3.5 text-sm outline-none transition focus:border-mora-accent" placeholder="01xxxxxxxxx">

                        @error('phone')
                        <p class="mt-2 text-xs text-red-400">
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                </div>

                <div>
                    <label for="gender" class="mb-2 block text-sm font-medium text-mora-text">
                        النوع
                    </label>

                    <select id="gender" name="gender" required class="w-full rounded-md border border-mora-border bg-mora-surface px-4 py-3 text-sm text-mora-text outline-none transition focus:border-mora-accent">
                        <option value="">اختر النوع</option>

                        <option value="male" @selected(old('gender')==='male' )>
                            ذكر
                        </option>

                        <option value="female" @selected(old('gender')==='female' )>
                            أنثى
                        </option>
                    </select>

                    @error('gender')
                    <p class="mt-2 text-xs text-red-400">
                        {{ $message }}
                    </p>
                    @enderror
                </div>


                <div>
                    <label for="password" class="mb-2 block text-xs font-bold uppercase tracking-[0.15em]">
                        كلمة المرور
                    </label>

                    <input id="password" type="password" name="password" required autocomplete="new-password" class="w-full rounded-[6px] border border-mora-border bg-mora-surface px-4 py-3.5 text-sm outline-none transition focus:border-mora-accent" placeholder="At least 8 characters">

                    @error('password')
                    <p class="mt-2 text-xs text-red-400">
                        {{ $message }}
                    </p>
                    @enderror
                </div>


                <div>
                    <label for="password_confirmation" class="mb-2 block text-xs font-bold uppercase tracking-[0.15em]">
                        Confirm كلمة المرور
                    </label>

                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" class="w-full rounded-[6px] border border-mora-border bg-mora-surface px-4 py-3.5 text-sm outline-none transition focus:border-mora-accent" placeholder="Repeat your password">
                </div>


                <button type="submit" class="mt-2 flex w-full items-center justify-center rounded-[6px] bg-mora-accent px-6 py-4 text-sm font-bold uppercase tracking-wide text-black transition hover:bg-mora-accent-hover">
                    إنشاء الحساب
                </button>

            </form>

        </div>


        <p class="mt-8 text-center text-sm text-mora-muted">
            لديك حساب بالفعل؟

            <a href="{{ route('login') }}" class="font-semibold text-mora-text transition hover:text-mora-accent">
                تسجيل الدخول
            </a>
        </p>

    </div>

</div>

@endsection
