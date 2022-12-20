<section class="order-section row">
    @if($order->isCanceled())
    <div class="col-12 mb-4">
        <div class="p-3 bg-red-300 color-red-900 text-lg">Canceled</div>
    </div>
    @elseif(!$order->isSubmitted())
        @include('orders._continue')
    @endif
    <div class="col-12">
        <div class="order-status">
            <span class="badge badge-secondary js-order-refresh--stage"
                  id="js-order-refresh"
                  data-href="{{ route('order-refresh-api', $order->id) }}">
                {{ ($order->stage == 'Department Approval')? 'Spend Authorizer Approval' : $order->stage }}
            </span>
        </div>

        <h2>{{ $order->typeName() }}</h2>

        <div class="mb-3">
            @include('orders._fiscal-contact')
        </div>
    </div>
    <div class="col-md-7">

        @include('orders._items', ['canEdit' => $canEdit->items])

        <div class="mw-600">
            <task-list url="{{ route('tasks-api', $order->id) }}"></task-list>
        </div>

        <div class="order-actions">
        @if($canEdit->cancel)
                <a class="btn btn-text" href="{{ route('cancel-order', $order->id) }}">&times; Cancel Order...</a>
        @endif
            <button class="btn btn-text" onclick="$('#js-log-box').load('{{ route('log', $order->id) }}')">Log</button>
        </div>

    </div>
    <div class="col-md-5">

        <ariba-section url="{{ route('ariba-api', $order->id) }}" :can-edit="{{ $canEdit->ariba ? 'true' : 'false' }}"></ariba-section>

        @include('orders._budgets', ['canEdit' => $canEdit->budgets])

        @if($order->hasTripNotes())
            @include('orders._trip-notes', ['notes' => $order->getTripNotes()])
        @endif

        <div class="note__column">
            <notes-section id="{{ $order->id }}" section="order"></notes-section>
        </div>

    </div>
    <div class="col-12">
        <div id="js-log-box"></div>
    </div>
</section>
