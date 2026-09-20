<?php $__env->startSection('content'); ?>
<div class="mt-12 rounded-2xl border border-mora-border bg-mora-card px-6 py-12 sm:px-10">
    <p class="font-display text-7xl font-bold text-mora-accent sm:text-8xl">403</p>
    <h1 class="mt-6 font-display text-3xl font-semibold text-mora-text sm:text-4xl">
        لا تملك الصلاحية للوصول إلى هذه الصفحة.
    </h1>
    <p class="mx-auto mt-4 max-w-xl text-sm leading-7 text-mora-muted">
        ارجع إلى الصفحة الرئيسية أو سجّل الدخول بالحساب المناسب.
    </p>
    <a href="<?php echo e(route('home')); ?>" class="mt-8 inline-flex rounded-md bg-mora-accent px-6 py-3 text-sm font-semibold text-mora-bg transition hover:bg-mora-accent-hover">
        العودة إلى الرئيسية
    </a>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.error', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laravel\gm\resources\views/errors/403.blade.php ENDPATH**/ ?>