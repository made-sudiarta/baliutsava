
@if ($paginator->hasPages())
    <nav class="bali-pagination" aria-label="Navigasi halaman ucapan">
        {{-- Sebelumnya --}}
        @if ($paginator->onFirstPage())
            <span class="page-arrow disabled">&lsaquo;</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}"
               class="page-arrow"
               aria-label="Halaman sebelumnya">&lsaquo;</a>
        @endif

        {{-- Nomor halaman --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="page-dots">{{ $element }}</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="page-number active"
                              aria-current="page">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}"
                           class="page-number">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Berikutnya --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}"
               class="page-arrow"
               aria-label="Halaman berikutnya">&rsaquo;</a>
        @else
            <span class="page-arrow disabled">&rsaquo;</span>
        @endif
    </nav>
@endif
