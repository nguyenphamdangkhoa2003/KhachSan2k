@if ($paginator->hasPages())
    <div class="join w-full flex justify-end">

        <button class="join-item btn-sm btn-outline" wire:click="previousPage">{{ '<' }}</button>

        <!-- Pagination Elements -->
        @foreach ($elements as $element)
            <!-- Array Of Links -->
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    <!--  Use three dots when current page is greater than 3.  -->
                    @if ($paginator->currentPage() > 3 && $page === 2)
                        <button class="join-item btn btn-sm">...</button>
                    @endif

                    <!--  Show active page two pages before and after it.  -->
                    @if ($page == $paginator->currentPage())
                        <button class="join-item btn btn-sm bg-primary">{{ $page }}</button>
                    @elseif (
                        $page === $paginator->currentPage() + 1 ||
                            $page === $paginator->currentPage() + 2 ||
                            $page === $paginator->currentPage() - 1 ||
                            $page === $paginator->currentPage() - 2)
                        <button class="join-item btn btn-sm"
                            wire:click="gotoPage({{ $page }})">{{ $page }}</button>
                    @endif

                    <!--  Use three dots when current page is away from end.  -->
                    @if ($paginator->currentPage() < $paginator->lastPage() - 2 && $page === $paginator->lastPage() - 1)
                        <button class="join-item btn btn-sm">...</button>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        <button class="join-item btn-sm btn-outline" wire:click="nextPage">{{ '>' }}</button>
    </div>
@endif
