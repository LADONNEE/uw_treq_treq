<section>
    <div id="nav-pending" class="jump-nav__anchor"></div>
    <div class="js-collapse__button open" role="button" tabindex="0" aria-pressed="true">
        <h2>Pending Orders</h2>
    </div>
    <div class="js-collapse__content">

        <p>Orders that have been submitted, but not Complete or Canceled.</p>

        <p class="my-3">
            <a href="{{ route('pending-orders', 'all') }}" class="mr-3">
                All Pending <span class="badge badge-secondary">{{ count($orders) }}</span>
            </a>
            <a href="{{ route('pending-orders', 'department') }}" class="mr-3">
                Pending Department <span class="badge badge-secondary">{{ $countDepartment }}</span>
            </a>
            <a href="{{ route('pending-orders', 'budget') }}" class="mr-3">
                Pending Budget <span class="badge badge-secondary">{{ $countBudget }}</span>
            </a>
            <a href="{{ route('pending-orders', 'task') }}" class="mr-3">
                Pending Task <span class="badge badge-secondary">{{ $countTask }}</span>
            </a>
        </p>

        @include('home._table-status')

    </div>
</section>
