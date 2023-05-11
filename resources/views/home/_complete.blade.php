<section>
    <div id="nav-complete" class="jump-nav__anchor"></div>
    <div class="js-collapse__button open" role="button" tabindex="0" aria-pressed="true">
        <h2>Complete Orders</h2>
    </div>
    <div class="js-collapse__content">

        <p>Orders marked Complete.</p>

        @include('home._table-status', ['orders' => $reports->complete->orders])

    </div>
</section>
