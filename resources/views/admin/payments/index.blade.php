@extends('layouts.app')

@section('content')

<section class="min-h-screen bg-mora-bg px-5 pb-20 pt-32">

    <div class="mx-auto max-w-7xl">

        {{-- العنوان --}}
        <div class="mb-10">

            <p class="mb-3 text-sm font-semibold tracking-[0.2em] text-mora-accent">
                إدارة المدفوعات
            </p>

            <h1 class="font-display text-5xl font-bold text-mora-text md:text-6xl">
                طلبات الدفع
            </h1>

            <p class="mt-3 max-w-2xl text-mora-muted">
                راجع تحويلات فودافون كاش وتأكد من بيانات العملية قبل تفعيل العضويات.
            </p>

        </div>


        {{-- الطلبات --}}
        <div class="overflow-hidden rounded-xl border border-mora-border bg-mora-card">

            @forelse ($payments as $payment)

            <div class="border-b border-mora-border p-6 last:border-b-0">

                <div class="flex flex-col gap-6 xl:flex-row xl:items-center xl:justify-between">

                    {{-- العضو --}}
                    <div class="min-w-0">

                        <p class="text-xs font-semibold tracking-wider text-mora-accent">
                            عضو
                        </p>

                        <h2 class="mt-2 text-lg font-semibold text-mora-text">
                            {{ $payment->user->name }}
                        </h2>

                        <p class="mt-1 text-sm text-mora-muted">
                            {{ $payment->user->email }}
                        </p>

                        @if ($payment->user->phone)
                        <p class="mt-1 text-sm text-mora-muted">
                            {{ $payment->user->phone }}
                        </p>
                        @endif

                    </div>


                    {{-- الاشتراك --}}
                    <div>

                        <p class="text-xs text-mora-muted">
                            العضوية
                        </p>

                        <p class="mt-2 font-semibold text-mora-text">
                            {{ $payment->subscription->membershipPlan->name }}
                        </p>

                    </div>


                    {{-- المبلغ --}}
                    <div>

                        <p class="text-xs text-mora-muted">
                            المبلغ
                        </p>

                        <p class="mt-2 font-display text-2xl font-bold text-mora-accent">
                            {{ number_format((float) $payment->amount, 0) }}
                            <span class="text-xs font-normal text-mora-muted">
                                جنيه
                            </span>
                        </p>

                    </div>


                    {{-- رقم العملية --}}
                    <div>

                        <p class="text-xs text-mora-muted">
                            رقم العملية
                        </p>

                        <p class="mt-2 font-mono font-semibold text-mora-text">
                            {{ $payment->transaction_reference }}
                        </p>

                        @if ($payment->paid_at)
                        <p class="mt-1 text-xs text-mora-muted">
                            {{ $payment->paid_at->format('d/m/Y - h:i A') }}
                        </p>
                        @endif

                    </div>


                    {{-- الإجراءات --}}
                    <div class="flex flex-col gap-3 sm:flex-row">

                        <form method="POST" action="{{ route('admin.payments.approve', $payment->id) }}">
                            @csrf

                            <button type="submit" class="w-full rounded-md bg-mora-accent px-5 py-3 text-sm font-semibold text-mora-bg transition hover:bg-mora-accent-hover">
                                تأكيد الدفع
                            </button>

                        </form>


                        <form method="POST" action="{{ route('admin.payments.reject', $payment->id) }}">
                            @csrf

                            <input type="hidden" name="notes" value="تم رفض عملية التحويل بعد المراجعة.">

                            <button type="submit" class="w-full rounded-md border border-red-500/30 px-5 py-3 text-sm font-semibold text-red-400 transition hover:bg-red-500/10">
                                رفض العملية
                            </button>

                        </form>

                    </div>

                </div>

            </div>

            @empty

            <div class="p-12 text-center">

                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-mora-accent/10">

                    <span class="font-display text-2xl font-bold text-mora-accent">
                        M
                    </span>

                </div>

                <h2 class="mt-6 font-display text-2xl font-bold text-mora-text">
                    لا توجد طلبات دفع
                </h2>

                <p class="mt-2 text-sm text-mora-muted">
                    لا توجد حاليًا عمليات تحويل تحتاج إلى مراجعة.
                </p>

            </div>

            @endforelse

        </div>


        @if ($payments->hasPages())

        <div class="mt-6">
            {{ $payments->links() }}
        </div>

        @endif

    </div>

</section>

@endsection
