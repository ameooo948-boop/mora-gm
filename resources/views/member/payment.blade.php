@extends('layouts.app')

@section('content')

<section class="min-h-screen bg-mora-bg px-5 pb-20 pt-32">

    <div class="mx-auto max-w-3xl">

        <div class="mb-10">

            <p class="mb-3 text-sm font-semibold tracking-[0.2em] text-mora-accent">
                إتمام الاشتراك
            </p>

            <h1 class="font-display text-5xl font-bold text-mora-text">
                الدفع عبر فودافون كاش
            </h1>

            <p class="mt-4 text-mora-muted">
                أكمل عملية التحويل ثم أرسل بيانات العملية لمراجعتها.
            </p>

        </div>


        {{-- تفاصيل الاشتراك --}}
        <div class="mb-6 rounded-xl border border-mora-border bg-mora-card p-6 md:p-8">

            <div class="flex items-center justify-between gap-5">

                <div>
                    <p class="text-sm text-mora-muted">
                        العضوية المختارة
                    </p>

                    <h2 class="mt-2 font-display text-3xl font-bold text-mora-text">
                        {{ $payment->subscription->membershipPlan->name }}
                    </h2>
                </div>

                <div class="text-left">

                    <p class="text-sm text-mora-muted">
                        المبلغ المطلوب
                    </p>

                    <p class="mt-2 font-display text-3xl font-bold text-mora-accent">
                        {{ number_format((float) $payment->amount, 0) }}
                        <span class="text-sm font-normal text-mora-muted">
                            جنيه
                        </span>
                    </p>

                </div>

            </div>

        </div>


        {{-- تعليمات الدفع --}}
        <div class="mb-6 rounded-xl border border-mora-accent/20 bg-mora-accent/5 p-6 md:p-8">

            <h2 class="font-display text-2xl font-bold text-mora-text">
                طريقة الدفع
            </h2>

            <div class="mt-6 space-y-4 text-sm leading-7 text-mora-muted">

                <p>
                    1. قم بتحويل قيمة العضوية إلى رقم Vodafone Cash الخاص بـ MORA.
                </p>

                <p>
                    2. احتفظ برقم العملية بعد إتمام التحويل.
                </p>

                <p>
                    3. أدخل رقم العملية وتاريخ ووقت التحويل في النموذج أدناه.
                </p>

                <p>
                    4. ستقوم إدارة MORA بمراجعة التحويل وتفعيل عضويتك بعد التأكد من عملية الدفع.
                </p>

            </div>


            <div class="mt-6 rounded-lg border border-mora-border bg-mora-bg p-5">

                <p class="text-sm text-mora-muted">
                    رقم Vodafone Cash
                </p>

                @if ($gymProfile?->vodafone_cash)

                <p class="mt-2 font-display text-2xl font-bold tracking-wider text-mora-accent">
                    {{ $gymProfile->vodafone_cash }}
                </p>

                @else

                <p class="mt-2 text-sm font-semibold text-yellow-400">
                    رقم الدفع غير متاح حاليًا. يرجى التواصل مع إدارة MORA.
                </p>

                @endif

            </div>

        </div>


        {{-- بيانات التحويل --}}
        <form method="POST" action="{{ route('member.payment.submit', $payment->id) }}" class="rounded-xl border border-mora-border bg-mora-card p-6 md:p-8">

            @csrf

            <div class="mb-8">

                <h2 class="font-display text-2xl font-bold text-mora-text">
                    بيانات التحويل
                </h2>

                <p class="mt-2 text-sm text-mora-muted">
                    أدخل البيانات كما ظهرت لك بعد تنفيذ التحويل.
                </p>

            </div>


            <div class="space-y-6">

                <div>

                    <label for="transaction_reference" class="mb-2 block text-sm font-medium text-mora-text">
                        رقم العملية
                    </label>

                    <input id="transaction_reference" name="transaction_reference" type="text" value="{{ old('transaction_reference', $payment->transaction_reference) }}" placeholder="أدخل رقم عملية التحويل" class="w-full rounded-md border border-mora-border bg-mora-bg px-4 py-3 text-mora-text outline-none transition placeholder:text-mora-muted/60 focus:border-mora-accent" required>

                    @error('transaction_reference')
                    <p class="mt-2 text-sm text-red-400">
                        {{ $message }}
                    </p>
                    @enderror

                </div>


                <div>

                    <label for="paid_at" class="mb-2 block text-sm font-medium text-mora-text">
                        تاريخ ووقت التحويل
                    </label>

                    <input id="paid_at" name="paid_at" type="datetime-local" value="{{ old('paid_at', $payment->paid_at?->format('Y-m-d\TH:i')) }}" class="w-full rounded-md border border-mora-border bg-mora-bg px-4 py-3 text-mora-text outline-none transition focus:border-mora-accent" required>

                    @error('paid_at')
                    <p class="mt-2 text-sm text-red-400">
                        {{ $message }}
                    </p>
                    @enderror

                </div>

            </div>


            @error('payment')
            <div class="mt-6 rounded-md border border-red-500/20 bg-red-500/10 p-4 text-sm text-red-400">
                {{ $message }}
            </div>
            @enderror


            <button type="submit" class="mt-8 w-full rounded-md bg-mora-accent px-6 py-3.5 font-semibold text-mora-bg transition hover:bg-mora-accent-hover">
                إرسال بيانات التحويل للمراجعة
            </button>

        </form>

    </div>

</section>

@endsection
