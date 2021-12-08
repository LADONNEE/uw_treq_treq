<section>
    <div id="nav-my-orders" class="jump-nav__anchor"></div>
    <div class="js-collapse__button open" role="button" tabindex="0" aria-pressed="true">
        <h2>My Orders</h2>
    </div>
    <div class="js-collapse__content">

        <p>
            Orders you submitted or are the owner of that are still pending action or were resolved in last 90 days.
            <a href="{{ route('reports', 'my-orders') }}">Show more</a>.
        </p>

        @include('home._table-status')

    </div>
</section>
