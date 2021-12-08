<div>
    <h3>{{ $order->id }}, {{ $order->action }}</h3>

    <ul>
        @foreach($order->items as $item)
            <li>{{ $item->name }} {{ $item->amount }}</li>
        @endforeach
    </ul>
</div>
