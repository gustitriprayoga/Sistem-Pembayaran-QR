<a href="/keranjang" class="btn btn-primary position-relative fw-semibold">
    My Basket
    @if($count > 0)
        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border border-light">
            {{ $count }}
            <span class="visually-hidden">items in cart</span>
        </span>
    @endif
</a>
