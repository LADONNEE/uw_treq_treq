<ul class="jump-nav">
    @if($reports->tasks->count)
        <li>
            <a href="#nav-tasks">
                Needs Action <span class="badge">{{ $reports->tasks->count }}</span>
            </a>
        </li>
    @endif
    @if($reports->creating->count)
        <li>
            <a href="#nav-creating">
                Creating <span class="badge">{{ $reports->creating->count }}</span>
            </a>
        </li>
    @endif
    <li>
        <a href="#nav-my-orders">
            My Orders <span class="badge">{{ $reports->myOrders->count }}</span>
        </a>
    </li>
    @if($reports->myTrips->count)
        <li>
            <a href="#nav-my-trips">
                My Trips <span class="badge">{{ $reports->myTrips->count }}</span>
            </a>
        </li>
    @endif

    @if(hasRole('treq:fiscal'))
        <li>
            <a href="#nav-on-call">
                On Call <span class="badge">{{ $reports->onCall->count }}</span>
            </a>
        </li>
        <li>
            <a href="#nav-pending">
                Pending <span class="badge">{{ $reports->pending->count }}</span>
            </a>
        </li>
    @endif
</ul>
