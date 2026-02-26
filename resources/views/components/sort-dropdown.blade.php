<div class="dropdown">
    <button class="btn btn-outline-primary dropdown-toggle rounded-pill px-4 shadow-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="bi bi-sort-down"></i>

        @switch(request('sort'))
        @case('price_asc') Price: Low to High @break
        @case('price_desc') Price: High to Low @break
        @case('name_asc') Name: A-Z @break
        @case('name_desc') Name: Z-A @break
        @case('newest') Newest Arrivals @break
        @default Sort by
        @endswitch
    </button>

    <ul class="dropdown-menu shadow border-0 mt-2">
        <li>
            <a class="dropdown-item {{ request('sort') == 'price_asc' ? 'active' : '' }}"
                href="{{ request()->fullUrlWithQuery(['sort' => 'price_asc']) }}">Price: Low to High</a>
        </li>
        <li>
            <a class="dropdown-item {{ request('sort') == 'price_desc' ? 'active' : '' }}"
                href="{{ request()->fullUrlWithQuery(['sort' => 'price_desc']) }}">Price: High to Low</a>
        </li>

        <li>
            <hr class="dropdown-divider">
        </li>

        <li>
            <a class="dropdown-item {{ request('sort') == 'name_asc' ? 'active' : '' }}"
                href="{{ request()->fullUrlWithQuery(['sort' => 'name_asc']) }}">Name: A-Z</a>
        </li>
        <li>
            <a class="dropdown-item {{ request('sort') == 'name_desc' ? 'active' : '' }}"
                href="{{ request()->fullUrlWithQuery(['sort' => 'name_desc']) }}">Name: Z-A</a>
        </li>

        <li>
            <hr class="dropdown-divider">
        </li>

        <li>
            <a class="dropdown-item {{ request('sort') == 'newest' ? 'active' : '' }}"
                href="{{ request()->fullUrlWithQuery(['sort' => 'newest']) }}">Newest Arrivals</a>
        </li>

        @if(request()->has('sort'))
        <li>
            <hr class="dropdown-divider">
        </li>
        <li>
            <a class="dropdown-item text-danger" href="{{ request()->fullUrlWithQuery(['sort' => null]) }}">
                Reset Sort
            </a>
        </li>
        @endif
    </ul>
</div>