<hr>

<section class="order-section row">
    @if($order->isCanceled())
        <div class="col-12 mb-4">
            <div class="p-3 bg-red-300 color-red-900 text-lg">Canceled</div>
        </div>
    @endif
    <div class="col-12">
        <div class="order-status">
            <span class="badge badge-secondary">{{ $order->stage }}</span>
        </div>

        <h2>{{ $order->typeName() }}</h2>

        <div class="mb-3">
            @if($order->assigned_to)
                Contact: {{ eFirstLast($order->assignee) }}
            @else
                <span class="empty">No fiscal contact</span>
            @endif
        </div>
    </div>
    <div class="col-md-7">

        @include('orders._items', ['canEdit' => false])

        <div class="mw-600">
            @include('print._tasks')
        </div>
    </div>
    <div class="col-md-5">

        @include('orders._ariba', ['canEdit' => false])

        @include('orders._budgets', ['canEdit' => false])

        @if($order->hasTripNotes())
            @include('orders._trip-notes', ['notes' => $order->getTripNotes(), 'canEdit' => false])
        @endif

        @include('notes._section-ro', ['notes' => $order->notes])

    </div>
</section>
