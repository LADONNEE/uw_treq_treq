<section>
    <div id="nav-creating" class="jump-nav__anchor"></div>
    <div class="js-collapse__button open" role="button" tabindex="0" aria-pressed="true">
        <h2>
            Creating
            <span class="badge badge-danger ml-2">{{ $count }} Not Submitted</span>
        </h2>
    </div>
    <div class="js-collapse__content">

        <p>Orders you have started creating, but have not been submitted for approval and action.</p>

        <div class="panel-full-width mb-5">
            <div class="row">
                <div class="col-md-10">
                </div>
                <div class="col-md-2">

                    <button id="toggle-filters" class="btn btn-primary mb-2 toggle-filters">Toggle Filters</button>
                </div>
            </div>
            <table class="table-tight ">
                <thead>
                <tr>
                    <th style="width: 8rem;">Project #</th>
                    <th style="width:15%;">Started</th>
                    <th>Title</th>
                    <th style="width:20%;">Last Action</th>
                    <th style="width:20%;">Stage</th>
                </tr>
                </thead>
                <tbody>
                @foreach($orders as $order)

                    <tr>
                        <td><a href="{{ route('next', $order->id) }}" class="js-link-row">@projectNumber($order)</a>
                        </td>
                        <td>
                            <div>{{ eDate($order->created_at) }}</div>
                            <div class="text-sm text-muted">{{ eFirstLast($order->submitter) }}</div>
                        </td>
                        <td>
                            <div><a href="{{ route('next', $order->id) }}" class="js-link-row">{{ $order->project->title }}</a></div>
                            <div class="text-sm text-muted">{{ $order->typeName() }}</div>
                        </td>
                        <td>
                            <div>Started new order</div>
                            <div class="text-sm text-muted">{{ $order->created_at->diffForHumans() }}</div>
                        </td>
                        <td>{{ ($order->stage == 'Department Approval')? 'Spend Authorizer Approval' : $order->stage }}</td>
                    </tr>

                @endforeach

                </tbody>
            </table>
        </div>

    </div>
</section>
