@if(count($orders) === 0)

    <div class="empty-table my-3">
        No matching orders.
    </div>

@else

    <div class="panel-full-width mb-5">
        <table class="table-tight sortable">
            <thead>
            <tr>
                <th style="width: 8rem;">Project #</th>
                <th style="width:15%;">Submitted</th>
                <th>Title</th>
                <th style="width:20%;">Last Action</th>
                <th style="width:20%;">Stage</th>
                <th style="width: 20px;"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($orders as $order)

                <tr>
                    <td><a href="{{ route('order', $order->id) }}" class="js-link-row">@projectNumber($order)</a></td>
                    <td>
                        <div>{{ ($order->submitted_at) ? eDate($order->submitted_at) : 'Not Submitted' }}</div>
                        <div class="text-sm text-muted">{{ eFirstLast($order->submitter) }}</div>
                    </td>
                    <td>
                        <div><a href="{{ route('order', $order->id) }}" class="js-link-row">{{ $order->project->title }}</a></div>
                        <div class="text-sm text-muted">{{ $order->typeName() }}</div>
                    </td>
                    @if($order->tracking)

                        <td>
                            <div>{{ ($order->tracking->last_action == 'Department Approval')? 'Spend Authorizer Approval' : $order->tracking->last_action }}</div>
                            <div class="text-sm text-muted">{{ $order->tracking->last_actor }} {{ eDate($order->tracking->last_at) }}</div>
                        </td>
                        <td>
                            <div>{{ ($order->tracking->next_action == 'Department Approval')? 'Spend Authorizer Approval' : $order->tracking->next_action }}</div>
                            <div class="text-sm text-muted">{{ $order->tracking->next_actors }}</div>
                        </td>

                    @else

                        <td>
                            <div>{{ ($order->stage == 'Department Approval')? 'Spend Authorizer Approval' : $order->stage }}</div>
                            <div class="text-sm text-muted">{{ eFirstLast($order->submitted_by) }} {{ eDate($order->created_at) }}</div>
                        </td>
                        <td>
                            <div>{{ ($order->stage == 'Department Approval')? 'Spend Authorizer Approval' : $order->stage }}</div>
                        </td>

                    @endif
                    <td>
                        @if($order->on_call)
                            <span class="on-call__bug" title="Order is in the On-Call queue">@icon('pager')</span>
                            <span class="sr-only">Order is in the On-Call queue</span>
                        @endif
                    </td>
                </tr>

            @endforeach

            </tbody>
        </table>
    </div>

@endif
