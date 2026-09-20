<aside class="fixed inset-y-0 right-0 z-50 hidden w-72 flex-col border-l border-mora-border bg-mora-surface lg:flex">
    <div class="flex h-20 shrink-0 items-center justify-between border-b border-mora-border px-6">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3" aria-label="لوحة إدارة MORA GYM">
            <div class="flex h-10 w-10 items-center justify-center">
                <span class="font-display text-3xl font-bold text-mora-text">M</span>
            </div>

            <div class="leading-none">
                <span class="font-display text-2xl font-bold tracking-[0.12em]">MORA</span>
                <span class="mt-1 block text-[8px] font-semibold tracking-[0.45em] text-mora-accent">GYM</span>
            </div>
        </a>

        <span class="rounded-full border border-mora-accent/20 bg-mora-accent/10 px-2.5 py-1 text-[10px] font-semibold text-mora-accent">
            إدارة
        </span>
    </div>

    <div class="flex-1 overflow-y-auto px-4 py-6">
        <div class="mb-6 rounded-lg border border-mora-border bg-mora-card p-4">
            <p class="text-[11px] text-mora-muted">مسجل الدخول</p>
            <p class="mt-1 truncate text-sm font-semibold text-mora-text">
                {{ auth()->user()->name }}
            </p>
            <p class="mt-1 truncate text-xs text-mora-muted">
                {{ auth()->user()->email }}
            </p>
        </div>

        <nav class="space-y-7" aria-label="قائمة إدارة الموقع">
            <div>
                <p class="mb-2 px-3 text-[10px] font-semibold tracking-[0.16em] text-mora-muted">الرئيسية</p>

                <a href="{{ route('admin.dashboard') }}"
                   class="flex items-center gap-3 rounded-md px-3 py-3 text-sm font-medium transition {{ request()->routeIs('admin.dashboard') ? 'bg-mora-accent text-mora-bg' : 'text-mora-muted hover:bg-mora-card hover:text-mora-text' }}">
                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M3 11.5 12 4l9 7.5M5.5 10v9.5h13V10M9 19.5v-5h6v5" />
                    </svg>
                    لوحة الإدارة
                </a>
            </div>

            <div>
                <p class="mb-2 px-3 text-[10px] font-semibold tracking-[0.16em] text-mora-muted">إدارة الأعضاء</p>

                <div class="space-y-1">
                    <a href="{{ route('admin.members.index') }}"
                       class="flex items-center gap-3 rounded-md px-3 py-3 text-sm font-medium transition {{ request()->routeIs('admin.members.*') ? 'bg-mora-accent text-mora-bg' : 'text-mora-muted hover:bg-mora-card hover:text-mora-text' }}">
                        <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M16 20v-1.8a4.2 4.2 0 0 0-4.2-4.2H7.2A4.2 4.2 0 0 0 3 18.2V20M9.5 10a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm6.5-1.5a3 3 0 1 0 0-6m1 7.5a4.2 4.2 0 0 1 4 4.2V20" />
                        </svg>
                        الأعضاء
                    </a>

                    <a href="{{ route('admin.subscriptions.index') }}"
                       class="flex items-center gap-3 rounded-md px-3 py-3 text-sm font-medium transition {{ request()->routeIs('admin.subscriptions.*') ? 'bg-mora-accent text-mora-bg' : 'text-mora-muted hover:bg-mora-card hover:text-mora-text' }}">
                        <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M6 3.5h12A2.5 2.5 0 0 1 20.5 6v12a2.5 2.5 0 0 1-2.5 2.5H6A2.5 2.5 0 0 1 3.5 18V6A2.5 2.5 0 0 1 6 3.5Zm3 5h6M8 12h8M8 15.5h5" />
                        </svg>
                        الاشتراكات
                    </a>

                    <a href="{{ route('admin.payments.index') }}"
                       class="flex items-center gap-3 rounded-md px-3 py-3 text-sm font-medium transition {{ request()->routeIs('admin.payments.*') ? 'bg-mora-accent text-mora-bg' : 'text-mora-muted hover:bg-mora-card hover:text-mora-text' }}">
                        <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M3.5 7.5h17v10h-17v-10Zm0 3h17M7 15h3" />
                        </svg>
                        المدفوعات
                    </a>

                    <a href="{{ route('admin.attendance.index') }}"
                       class="flex items-center gap-3 rounded-md px-3 py-3 text-sm font-medium transition {{ request()->routeIs('admin.attendance.*') ? 'bg-mora-accent text-mora-bg' : 'text-mora-muted hover:bg-mora-card hover:text-mora-text' }}">
                        <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M7 4h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2Zm2 4h6M9 12h6M9 16h4" />
                        </svg>
                        الحضور والانصراف
                    </a>
                </div>
            </div>

            <div>
                <p class="mb-2 px-3 text-[10px] font-semibold tracking-[0.16em] text-mora-muted">إدارة الجيم</p>

                <div class="space-y-1">
                    <a href="{{ route('admin.training-sessions.index') }}"
                       class="flex items-center gap-3 rounded-md px-3 py-3 text-sm font-medium transition {{ request()->routeIs('admin.training-sessions.*') ? 'bg-mora-accent text-mora-bg' : 'text-mora-muted hover:bg-mora-card hover:text-mora-text' }}">
                        <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M4 12h16M7 7h10M7 17h10M6 4v16M18 4v16" />
                        </svg>
                        مواعيد التدريب
                    </a>

                    <a href="{{ route('admin.trainers.index') }}"
                       class="flex items-center gap-3 rounded-md px-3 py-3 text-sm font-medium transition {{ request()->routeIs('admin.trainers.*') ? 'bg-mora-accent text-mora-bg' : 'text-mora-muted hover:bg-mora-card hover:text-mora-text' }}">
                        <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M12 13a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm-6 7a6 6 0 0 1 12 0M17 8h4M19 6v4" />
                        </svg>
                        المدربون
                    </a>

                    <a href="{{ route('admin.membership-plans.index') }}"
                       class="flex items-center gap-3 rounded-md px-3 py-3 text-sm font-medium transition {{ request()->routeIs('admin.membership-plans.*') ? 'bg-mora-accent text-mora-bg' : 'text-mora-muted hover:bg-mora-card hover:text-mora-text' }}">
                        <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M4 7.5 12 4l8 3.5L12 11 4 7.5Zm0 0V16l8 4 8-4V7.5M8 9.5v7m8-7v7" />
                        </svg>
                        باقات العضوية
                    </a>

                    <a href="{{ route('admin.gallery.index') }}"
                       class="flex items-center gap-3 rounded-md px-3 py-3 text-sm font-medium transition {{ request()->routeIs('admin.gallery.*') ? 'bg-mora-accent text-mora-bg' : 'text-mora-muted hover:bg-mora-card hover:text-mora-text' }}">
                        <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M4 5.5h16v13H4v-13Zm0 9 4-4 3 3 2-2 7 7M15.5 9.5h.01" />
                        </svg>
                        معرض الصور
                    </a>
                </div>
            </div>

            <div>
                <p class="mb-2 px-3 text-[10px] font-semibold tracking-[0.16em] text-mora-muted">الإعدادات</p>

                <a href="{{ route('admin.gym-profile.index') }}"
                   class="flex items-center gap-3 rounded-md px-3 py-3 text-sm font-medium transition {{ request()->routeIs('admin.gym-profile.*') ? 'bg-mora-accent text-mora-bg' : 'text-mora-muted hover:bg-mora-card hover:text-mora-text' }}">
                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M12 3.5 14 5l2.5-.2.9 2.3 2.1 1.3-.7 2.4.7 2.4-2.1 1.3-.9 2.3L14 16.5l-2 1.5-2-1.5-2.5.3-.9-2.3-2.1-1.3.7-2.4-.7-2.4 2.1-1.3.9-2.3L10 5l2-1.5Z" />
                        <circle cx="12" cy="11.5" r="3" stroke-width="1.6" />
                    </svg>
                    إعدادات الجيم
                </a>
            </div>
        </nav>
    </div>

    <div class="shrink-0 border-t border-mora-border p-4">
        <a href="{{ route('home') }}" class="mb-2 flex items-center justify-center rounded-md border border-mora-border px-4 py-3 text-sm font-medium text-mora-muted transition hover:border-mora-accent hover:text-mora-accent">
            عرض الموقع
        </a>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="flex w-full items-center justify-center rounded-md border border-mora-border px-4 py-3 text-sm font-medium text-mora-text transition hover:border-red-500/40 hover:text-red-400">
                تسجيل الخروج
            </button>
        </form>
    </div>
</aside>

<div x-data="{ open: false }" class="lg:hidden">
    <header class="fixed inset-x-0 top-0 z-50 border-b border-mora-border bg-mora-bg/95 backdrop-blur-xl">
        <div class="flex h-16 items-center justify-between gap-4 px-5">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2" aria-label="لوحة إدارة MORA GYM">
                <span class="font-display text-xl font-bold tracking-[0.12em]">MORA</span>
                <span class="text-[8px] font-semibold tracking-[0.4em] text-mora-accent">GYM</span>
            </a>

            <button @click="open = !open" type="button" class="flex h-10 w-10 items-center justify-center rounded-md border border-mora-border text-mora-text" :aria-expanded="open" aria-label="فتح قائمة الإدارة">
                <svg x-show="!open" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <svg x-show="open" x-cloak class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="m6 6 12 12M18 6 6 18" />
                </svg>
            </button>
        </div>
    </header>

    <div x-show="open" x-cloak x-transition class="fixed inset-x-0 top-16 z-40 max-h-[calc(100vh-4rem)] overflow-y-auto border-b border-mora-border bg-mora-surface shadow-2xl">
        <nav class="space-y-1 p-4" aria-label="قائمة إدارة الموقع">
            <a @click="open = false" href="{{ route('admin.dashboard') }}" class="flex items-center rounded-md px-4 py-3 text-sm font-medium {{ request()->routeIs('admin.dashboard') ? 'bg-mora-accent text-mora-bg' : 'text-mora-muted' }}">لوحة الإدارة</a>
            <a @click="open = false" href="{{ route('admin.members.index') }}" class="flex items-center rounded-md px-4 py-3 text-sm font-medium {{ request()->routeIs('admin.members.*') ? 'bg-mora-accent text-mora-bg' : 'text-mora-muted' }}">الأعضاء</a>
            <a @click="open = false" href="{{ route('admin.subscriptions.index') }}" class="flex items-center rounded-md px-4 py-3 text-sm font-medium {{ request()->routeIs('admin.subscriptions.*') ? 'bg-mora-accent text-mora-bg' : 'text-mora-muted' }}">الاشتراكات</a>
            <a @click="open = false" href="{{ route('admin.payments.index') }}" class="flex items-center rounded-md px-4 py-3 text-sm font-medium {{ request()->routeIs('admin.payments.*') ? 'bg-mora-accent text-mora-bg' : 'text-mora-muted' }}">المدفوعات</a>
            <a @click="open = false" href="{{ route('admin.attendance.index') }}" class="flex items-center rounded-md px-4 py-3 text-sm font-medium {{ request()->routeIs('admin.attendance.*') ? 'bg-mora-accent text-mora-bg' : 'text-mora-muted' }}">الحضور والانصراف</a>
            <a @click="open = false" href="{{ route('admin.training-sessions.index') }}" class="flex items-center rounded-md px-4 py-3 text-sm font-medium {{ request()->routeIs('admin.training-sessions.*') ? 'bg-mora-accent text-mora-bg' : 'text-mora-muted' }}">مواعيد التدريب</a>
            <a @click="open = false" href="{{ route('admin.trainers.index') }}" class="flex items-center rounded-md px-4 py-3 text-sm font-medium {{ request()->routeIs('admin.trainers.*') ? 'bg-mora-accent text-mora-bg' : 'text-mora-muted' }}">المدربون</a>
            <a @click="open = false" href="{{ route('admin.membership-plans.index') }}" class="flex items-center rounded-md px-4 py-3 text-sm font-medium {{ request()->routeIs('admin.membership-plans.*') ? 'bg-mora-accent text-mora-bg' : 'text-mora-muted' }}">باقات العضوية</a>
            <a @click="open = false" href="{{ route('admin.gallery.index') }}" class="flex items-center rounded-md px-4 py-3 text-sm font-medium {{ request()->routeIs('admin.gallery.*') ? 'bg-mora-accent text-mora-bg' : 'text-mora-muted' }}">معرض الصور</a>
            <a @click="open = false" href="{{ route('admin.gym-profile.index') }}" class="flex items-center rounded-md px-4 py-3 text-sm font-medium {{ request()->routeIs('admin.gym-profile.*') ? 'bg-mora-accent text-mora-bg' : 'text-mora-muted' }}">إعدادات الجيم</a>
            <a @click="open = false" href="{{ route('home') }}" class="mt-3 flex items-center justify-center rounded-md border border-mora-border px-4 py-3 text-sm font-medium text-mora-muted">عرض الموقع</a>

            <form action="{{ route('logout') }}" method="POST" class="mt-2">
                @csrf
                <button type="submit" class="flex w-full items-center justify-center rounded-md border border-mora-border px-4 py-3 text-sm font-medium text-mora-text">
                    تسجيل الخروج
                </button>
            </form>
        </nav>
    </div>
</div>
