<div class="pagination-custom">
    @if ($paginator->hasPages())
        @if ($paginator->onFirstPage())
            <a class="pagi-prev disabled">
                <i class="fa fa-arrow-circle-left disabled" aria-hidden="true"></i>
            </a>
        @else
            <a class="pagi-prev" href="{{ $paginator->previousPageUrl() }}">
                <i class="fa fa-arrow-circle-left" aria-hidden="true"></i>
            </a>
        @endif

        @if ($paginator->hasMorePages())
            <a class="pagi-next" href="{{ $paginator->nextPageUrl() }}">
                <i class="fa fa-arrow-circle-right" aria-hidden="true"></i>
            </a>
        @else
            <a class="pagi-next disabled">
                <i class="fa fa-arrow-circle-right disabled" aria-hidden="true"></i>
            </a>
        @endif
    @endif
</div>
