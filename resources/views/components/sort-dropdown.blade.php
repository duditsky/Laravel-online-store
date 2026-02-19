<div class="dropdown">
    <button class="btn btn-outline-dark dropdown-toggle rounded-pill px-4 shadow-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="bi bi-sort-down"></i> Sort by
    </button>
    <ul class="dropdown-menu shadow border-0 mt-2">
        <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort' => 'price_asc']) }}">Price: Low to High</a></li>
        <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort' => 'price_desc']) }}">Price: High to Low</a></li>
        <li>
            <hr class="dropdown-divider">
        </li>
        <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort' => 'name_asc']) }}">Name: A-Z</a></li>
        <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort' => 'name_desc']) }}">Name: Z-A</a></li>
        <li>
            <hr class="dropdown-divider">
        </li>
        <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort' => 'newest']) }}">Newest Arrivals</a></li>
    </ul>
</div>