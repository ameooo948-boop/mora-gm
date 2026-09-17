<header x-data="{ open: false, scrolled: false }" x-init="window.addEventListener('scroll', () => scrolled = window.scrollY > 20)" :class="scrolled
        ? 'border-mora-border bg-mora-bg/90 backdrop-blur-xl'
        : 'border-transparent bg-transparent'" class="fixed inset-x-0 top-0 z-50 border-b transition-all duration-300">
    <div class="mx-auto flex h-20 max-w-7xl items-center justify-between px-5 sm:px-8 lg:px-10">

        {{-- Logo --}}
        <a href="/" class="group flex items-center gap-3" aria-label="الصفحة الرئيسية لـ MORA GYM">

            <div class="flex h-10 w-10 items-center justify-center">
                <span class="font-display text-3xl font-bold tracking-tight text-mora-text">
                    M
                </span>
            </div>

            <div class="leading-none">
                <span class="font-display text-2xl font-bold tracking-[0.12em]">
                    MORA
                </span>

                <span class="mt-1 block text-[8px] font-semibold tracking-[0.45em] text-mora-accent">
                    GYM
                </span>
            </div>

        </a>

        {{-- Desktop Navigation --}}
        <nav class="hidden items-center gap-8 lg:flex">

            <a href="/" class="text-sm font-medium text-mora-text transition hover:text-mora-accent">
                الرئيسية
            </a>

            <a href="{{ route('member.attendance') }}" class="transition hover:text-mora-accent">
                الحضور
            </a>

            <a href="#about" class="text-sm font-medium text-mora-muted transition hover:text-mora-accent">
                عن MORA
            </a>

            <a href="#memberships" class="text-sm font-medium text-mora-muted transition hover:text-mora-accent">
                العضويات
            </a>

            <a href="#trainer" class="text-sm font-medium text-mora-muted transition hover:text-mora-accent">
                المدربون
            </a>

            <a href="#gallery" class="text-sm font-medium text-mora-muted transition hover:text-mora-accent">
                معرض الصور
            </a>

            <a href="#contact" class="text-sm font-medium text-mora-muted transition hover:text-mora-accent">
                تواصل معنا
            </a>

            <a href="#sessions" class="text-sm font-medium text-mora-muted transition hover:text-mora-accent">
                مواعيد التدريب
            </a>

        </nav>

        {{-- Desktop CTA --}}
        @auth

        @if (auth()->user()->isAdmin())

        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center justify-center rounded-md bg-mora-accent px-5 py-2.5 text-sm font-semibold text-mora-bg transition hover:bg-mora-accent-hover">
            لوحة الإدارة
        </a>

        @else

        <a href="{{ route('member.dashboard') }}" class="inline-flex items-center justify-center rounded-md bg-mora-accent px-5 py-2.5 text-sm font-semibold text-mora-bg transition hover:bg-mora-accent-hover">
            لوحة التحكم
        </a>

        @endif

        @else

        <a href="{{ route('login') }}" class="inline-flex items-center justify-center rounded-md bg-mora-accent px-5 py-2.5 text-sm font-semibold text-mora-bg transition hover:bg-mora-accent-hover">
            تسجيل الدخول
        </a>

        @endauth

        {{-- Mobile Button --}}
        <button @click="open = !open" type="button" class="flex h-10 w-10 items-center justify-center text-mora-text lg:hidden" :aria-expanded="open" aria-label="فتح وإغلاق قائمة التنقل">
            <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16" />
            </svg>

            <svg x-show="open" x-cloak xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 6l12 12M18 6L6 18" />
            </svg>
        </button>

    </div>

    {{-- Mobile Navigation --}}
    <div x-show="open" x-cloak x-transition class="border-t border-mora-border bg-mora-bg lg:hidden">
        <nav class="mx-auto flex max-w-7xl flex-col px-5 py-6 sm:px-8">

            <a @click="open = false" href="/" class="border-b border-mora-border py-4 text-sm font-medium">
                الرئيسية
            </a>

            <a @click="open = false" href="#about" class="border-b border-mora-border py-4 text-sm font-medium text-mora-muted">
                عن MORA
            </a>

            <a @click="open = false" href="#memberships" class="border-b border-mora-border py-4 text-sm font-medium text-mora-muted">
                العضويات
            </a>

            <a @click="open = false" href="#trainer" class="border-b border-mora-border py-4 text-sm font-medium text-mora-muted">
                المدربون
            </a>

            <a @click="open = false" href="#gallery" class="border-b border-mora-border py-4 text-sm font-medium text-mora-muted">
                معرض الصور
            </a>

            <a @click="open = false" href="#contact" class="py-4 text-sm font-medium text-mora-muted">
                تواصل معنا
            </a>

            <a @click="open = false" href="#memberships" class="mt-4 flex items-center justify-center gap-3 bg-mora-accent px-5 py-4 text-xs font-bold tracking-wider text-black">
                اشترك الآن
                <span>→</span>
            </a>

        </nav>
    </div>
</header>
