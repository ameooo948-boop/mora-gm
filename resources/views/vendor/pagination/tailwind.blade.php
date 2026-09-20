@if ($paginator->hasPages())
    <nav role="navigation" aria-label="التنقل بين الصفحات" class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <p class="text-sm text-mora-muted">
            عرض {{ $paginator->firstItem() }} إلى {{ $paginator->lastItem() }} من إجمالي {{ $paginator->total() }} نتيجة
        </p>

        <div class="flex items-center gap-1">
            @if ($paginator->onFirstPage())
                <span class="inline-flex h-10 min-w-10 items-center justify-center rounded-md border border-mora-border bg-mora-card px-3 text-sm text-mora-muted" aria-disabled="true">
                    السابق
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="inline-flex h-10 min-w-10 items-center justify-center rounded-md border border-mora-border bg-mora-card px-3 text-sm font-medium text-mora-text transition hover:border-mora-accent hover:text-mora-accent">
                    السابق
                </a>
            @endif

            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="px-2 text-sm text-mora-muted">{{ $element }}</span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span aria-current="page" class="inline-flex h-10 min-w-10 items-center justify-center rounded-md bg-mora-accent px-3 text-sm font-bold text-mora-bg">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}" class="inline-flex h-10 min-w-10 items-center justify-center rounded-md border border-mora-border bg-mora-card px-3 text-sm font-medium text-mora-text transition hover:border-mora-accent hover:text-mora-accent">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="inline-flex h-10 min-w-10 items-center justify-center rounded-md border border-mora-border bg-mora-card px-3 text-sm font-medium text-mora-text transition hover:border-mora-accent hover:text-mora-accent">
                    التالي
                </a>
            @else
                <span class="inline-flex h-10 min-w-10 items-center justify-center rounded-md border border-mora-border bg-mora-card px-3 text-sm text-mora-muted" aria-disabled="true">
                    التالي
                </span>
            @endif
        </div>
    </nav>
@endif
