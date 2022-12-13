<section class="panel mt-4">

    <p class="text-sm text-muted pb-3 border-bottom">
        This section is for the fiscal team and includes orders submitted by all users.
        Shown to users with Fiscal role.
    </p>

    <div id="nav-unassigned" class="jump-nav__anchor"></div>
    <h2>Unassigned Orders</h2>

    <p>Orders that have received authorizer Approval, but are not assigned to a fiscal contact.</p>

    @include('home._table-status', ['orders' => $reports->unassigned->orders])


    <div id="nav-on-call" class="jump-nav__anchor"></div>
    <h2>On Call Orders</h2>

    <p>Orders marked On Call. These orders should be attended to by first available support team.</p>

    @include('home._table-status', ['orders' => $reports->onCall->orders])


    <div id="nav-pending" class="jump-nav__anchor"></div>
    <h2>Pending Orders</h2>

    <p>Orders that have been submitted, but not Complete or Canceled.</p>

    @include('home._table-status', ['orders' => $reports->pending->orders])

</section>
