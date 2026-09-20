<header x-data="{ open: false, scrolled: false }" x-init="window.addEventListener('scroll', () => scrolled = window.scrollY > 20)" :class="scrolled ? 'border-mora-border bg-mora-bg/90 backdrop-blur-xl' : 'border-transparent bg-transparent'" class="fixed inset-x-0 top-0 z-50 border-b transition-all duration-300">
    <div class="mx-auto flex h-20 max-w-7xl items-center justify-between gap-6 px-5 sm:px-8 lg:px-10">

        <a href="{{ route('home') }}" class="group flex shrink-0 items-center gap-3" aria-label="الصفحة الرئيسية لـ MORA GYM">
            <div class="flex h-10 w-10 items-center justify-center">
                <span class="font-display text-3xl font-bold tracking-tight text-mora-text">M</span>
            </div>

            <div class="leading-none">
                <span class="font-display text-2xl font-bold tracking-[0.12em]">MORA</span>
                <span class="mt-1 block text-[8px] font-semibold tracking-[0.45em] text-mora-accent">GYM</span>
            </div>
        </a>

        <nav class="hidden items-center gap-7 lg:flex">
            <a href="{{ route('home') }}" class="text-sm font-medium text-mora-text transition hover:text-mora-accent">الرئيسية</a>
            <a href="{{ route('home') }}#about" class="text-sm font-medium text-mora-muted transition hover:text-mora-accent">عن MORA</a>
            <a href="{{ route('home') }}#memberships" class="text-sm font-medium text-mora-muted transition hover:text-mora-accent">العضويات</a>
            <a href="{{ route('home') }}#trainer" class="text-sm font-medium text-mora-muted transition hover:text-mora-accent">المدربون</a>
            <a href="{{ route('home') }}#gallery" class="text-sm font-medium text-mora-muted transition hover:text-mora-accent">معرض الصور</a>
            <a href="{{ route('home') }}#sessions" class="text-sm font-medium text-mora-muted transition hover:text-mora-accent">مواعيد التدريب</a>
            <a href="{{ route('home') }}#contact" class="text-sm font-medium text-mora-muted transition hover:text-mora-accent">تواصل معنا</a>

            @auth
                @if (auth()->user()->isMember())
                    <span class="h-4 w-px bg-mora-border"></span>
                    <a href="{{ route('member.attendance') }}" class="text-sm font-medium text-mora-muted transition hover:text-mora-accent">الحضور</a>
                    <a href="{{ route('member.notifications') }}" class="relative text-sm font-medium text-mora-muted transition hover:text-mora-accent">
                        <span>الإشعارات</span>
                        @if (($unreadNotificationsCount ?? 0) > 0)
                            <span class="absolute -top-2 -left-3 flex min-w-5 h-5 items-center justify-center rounded-full bg-mora-accent px-1 text-[10px] font-bold leading-none text-mora-bg">
                                {{ $unreadNotificationsCount > 99 ? '99+' : $unreadNotificationsCount }}
                            </span>
                        @endif
                    </a>
                    <a href="{{ route('member.profile') }}" class="text-sm font-medium text-mora-muted transition hover:text-mora-accent">الملف الشخصي</a>
                @endif
            @endauth
        </nav>

        <div class="hidden shrink-0 items-center gap-3 lg:flex">
            @auth
                @if (auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center justify-center rounded-md bg-mora-accent px-5 py-2.5 text-sm font-semibold text-mora-bg transition hover:bg-mora-accent-hover">لوحة الإدارة</a>
                @else
                    <a href="{{ route('member.dashboard') }}" class="inline-flex items-center justify-center rounded-md bg-mora-accent px-5 py-2.5 text-sm font-semibold text-mora-bg transition hover:bg-mora-accent-hover">لوحة التحكم</a>
                @endif

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="inline-flex items-center justify-center rounded-md border border-mora-border px-5 py-2.5 text-sm font-semibold text-mora-text transition hover:border-mora-accent hover:text-mora-accent">تسجيل الخروج</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="inline-flex items-center justify-center rounded-md bg-mora-accent px-5 py-2.5 text-sm font-semibold text-mora-bg transition hover:bg-mora-accent-hover">تسجيل الدخول</a>
            @endauth
        </div>

        <button @click="open = !open" type="button" class="flex h-10 w-10 shrink-0 items-center justify-center text-mora-text lg:hidden" :aria-expanded="open" aria-label="فتح وإغلاق قائمة التنقل">
            <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
            <svg x-show="open" x-cloak xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 6l12 12M18 6L6 18" />
            </svg>
        </button>
    </div>

    <div x-show="open" x-cloak x-transition class="border-t border-mora-border bg-mora-bg lg:hidden">
        <nav class="mx-auto flex max-w-7xl flex-col px-5 py-6 sm:px-8">
            <a @click="open = false" href="{{ route('home') }}" class="border-b border-mora-border py-4 text-sm font-medium">الرئيسية</a>
            <a @click="open = false" href="{{ route('home') }}#about" class="border-b border-mora-border py-4 text-sm font-medium text-mora-muted">عن MORA</a>
            <a @click="open = false" href="{{ route('home') }}#memberships" class="border-b border-mora-border py-4 text-sm font-medium text-mora-muted">العضويات</a>
            <a @click="open = false" href="{{ route('home') }}#trainer" class="border-b border-mora-border py-4 text-sm font-medium text-mora-muted">المدربون</a>
            <a @click="open = false" href="{{ route('home') }}#gallery" class="border-b border-mora-border py-4 text-sm font-medium text-mora-muted">معرض الصور</a>
            <a @click="open = false" href="{{ route('home') }}#sessions" class="border-b border-mora-border py-4 text-sm font-medium text-mora-muted">مواعيد التدريب</a>
            <a @click="open = false" href="{{ route('home') }}#contact" class="border-b border-mora-border py-4 text-sm font-medium text-mora-muted">تواصل معنا</a>

            @auth
                @if (auth()->user()->isMember())
                    <a @click="open = false" href="{{ route('member.attendance') }}" class="border-b border-mora-border py-4 text-sm font-medium text-mora-muted">الحضور</a>
                    <a @click="open = false" href="{{ route('member.notifications') }}" class="border-b border-mora-border py-4 text-sm font-medium text-mora-muted">الإشعارات @if (($unreadNotificationsCount ?? 0) > 0)<span class="mr-2 rounded-full bg-mora-accent px-2 py-0.5 text-[10px] font-bold text-mora-bg">{{ $unreadNotificationsCount > 99 ? '99+' : $unreadNotificationsCount }}</span>@endif</a>
                    <a @click="open = false" href="{{ route('member.profile') }}" class="border-b border-mora-border py-4 text-sm font-medium text-mora-muted">الملف الشخصي</a>
                @endif

                @if (auth()->user()->isAdmin())
                    <a @click="open = false" href="{{ route('admin.dashboard') }}" class="mt-4 flex items-center justify-center rounded-md bg-mora-accent px-5 py-4 text-xs font-bold text-mora-bg">لوحة الإدارة</a>
                @else
                    <a @click="open = false" href="{{ route('member.dashboard') }}" class="mt-4 flex items-center justify-center rounded-md bg-mora-accent px-5 py-4 text-xs font-bold text-mora-bg">لوحة التحكم</a>
                @endif

                <form action="{{ route('logout') }}" method="POST" class="mt-3">
                    @csrf
                    <button type="submit" class="flex w-full items-center justify-center rounded-md border border-mora-border px-5 py-4 text-xs font-bold text-mora-text">تسجيل الخروج</button>
                </form>
            @else
                <a @click="open = false" href="{{ route('login') }}" class="mt-4 flex items-center justify-center rounded-md bg-mora-accent px-5 py-4 text-xs font-bold text-mora-bg">تسجيل الدخول</a>
            @endauth
        </nav>
    </div>
</header>
