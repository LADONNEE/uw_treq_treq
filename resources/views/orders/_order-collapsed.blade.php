<div class="panel mb-3 js-order-load--target">
    <div class="order-collapsed">
        <div class="order-status">
            <span class="badge badge-secondary">{{ ($order->stage == 'Department Approval')? 'Spend Authorizer Approval' : $order->stage }}</span>
        </div>
        <div class="order-collapsed__type">{{ $order->typeName() }}</div>
        <div class="order-collapsed__submitted">{{ eDate($order->submitted_at) }} by {{ eFirstLast($order->submitted_by) }}</div>
        <div class="order-actions">
            <a href="{{ route('order-partial', $order->id) }}" class="js-order-load">@icon('chevron-down') Show</a>
            <a href="{{ route('order', $order->id) }}">@icon('pen') Edit</a>
        </div>
    </div>
</div>
