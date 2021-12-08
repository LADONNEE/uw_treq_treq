@if($order->items || $emptyMessage)

    <section class="mb-4">
        @if($items)

            @if($canEdit)
            <div class="float-right text-sm-bold">
                <a href="{{ route('travel-items', $order->id) }}">Change Items</a>
            </div>
            @endif

            <table class="table-tight">
                <thead>
                <tr>
                    <th>Item</th>
                    <th class="text-right">Amount</th>
                </tr>
                </thead>
                <tbody>

                @foreach($order->items as $item)

                    <tr>
                        <td>{{ $item->name }}</td>
                        <td class="text-right">{{ $item->amount }}</td>
                    </tr>

                @endforeach

                </tbody>
            </table>

        @else

            @if($canEdit)
                <p><a href="{{ route('travel-items', $order->id) }}">&plus; Items</a></p>
            @elseif($emptyMessage)
                <div class="empty-table">{{ $emptyMessage }}</div>
            @endif

        @endif
    </section>

@endif
