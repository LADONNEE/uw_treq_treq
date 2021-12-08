<section>
    <div id="nav-on-call" class="jump-nav__anchor"></div>
    <div class="js-collapse__button open" role="button" tabindex="0" aria-pressed="true">
        <h2>On Call Orders</h2>
    </div>
    <div class="js-collapse__content">

        <p>Orders marked On Call. These orders should be attended to by first available support team.</p>

        @include('home._table-status', ['orders' => $reports->onCall->orders])

    </div>
</section>
