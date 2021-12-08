<section>
    <div id="nav-tasks" class="jump-nav__anchor"></div>
    <div class="js-collapse__button open" role="button" tabindex="0" aria-pressed="true">
        <h2>
            Needs Action
            <span class="badge badge-danger ml-2">{{ $count }} {{ ($count === 1) ? 'Order' : 'Orders' }}</span>
        </h2>
    </div>
    <div class="js-collapse__content">

        <p>These orders need your review, approval, or a task completed.</p>

        @include('home._table-status')

    </div>
</section>
