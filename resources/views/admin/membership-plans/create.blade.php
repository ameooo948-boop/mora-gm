@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-4xl px-5 py-10">

    <div class="mb-8">
        <a href="{{ route('admin.membership-plans.index') }}" class="text-sm text-mora-muted transition hover:text-mora-accent">
            ← العودة إلى خطط العضوية
        </a>

        <h1 class="mt-5 font-display text-3xl font-bold text-white">
            إضافة خطة عضوية
        </h1>

        <p class="mt-2 text-sm text-mora-muted">
            أضف تفاصيل خطة الاشتراك الجديدة.
        </p>
    </div>

    <form method="POST" action="{{ route('admin.membership-plans.store') }}" x-data="membershipPlanForm()" class="space-y-6">
        @csrf

        @include('admin.membership-plans._form')

        <div class="flex flex-col gap-3 sm:flex-row">
            <button type="submit" class="rounded-md bg-mora-accent px-6 py-3 text-sm font-bold text-black transition hover:bg-mora-accent-hover">
                حفظ الخطة
            </button>

            <a href="{{ route('admin.membership-plans.index') }}" class="rounded-md border border-mora-border px-6 py-3 text-center text-sm font-semibold text-white transition hover:border-mora-accent">
                إلغاء
            </a>
        </div>
    </form>

</div>

<script>
    function membershipPlanForm() {
        return {
            features: @json(old('features', [''])),

            addFeature() {
                this.features.push('');
            },

            removeFeature(index) {
                if (this.features.length === 1) {
                    this.features[0] = '';
                    return;
                }

                this.features.splice(index, 1);
            }
        }
    }

</script>
@endsection
