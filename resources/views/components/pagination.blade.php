@if (isset($paginator))
@php
    $queryParams = (isset($appends) && gettype($appends) === 'array') ? '&' . http_build_query($appends) : ''
@endphp
    <nav role="navigation" aria-label="Pagination Navigation" class="flex justify-between">
        {{-- Previous Page Link --}}
        @if ($paginator->isFirstPage())
            <span class="previous">
                {!! __('pagination.previous') !!}
            </span>
        @else
            <a href="?page={{ $paginator->getNumberPreviousPage() }}{{ $queryParams }}" rel="prev" class="previous">
                {!! __('pagination.previous') !!}
            </a>
        @endif

        {{-- Next Page Link --}}
        @if (!$paginator->isLastPage())
            <a href="?page={{ $paginator->getNumberNextPage() }}{{ $queryParams }}" rel="next" class="next">
                {!! __('pagination.next') !!}
            </a>
        @else
            <span class="next">
                {!! __('pagination.next') !!}
            </span>
        @endif
    </nav>
@endif
