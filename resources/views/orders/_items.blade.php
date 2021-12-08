<section class="mb-4">
    @if($order->items)

        @if($canEdit)
            <div class="text-right text-sm-bold mb-1">
                <a href="{{ route('items', $order->id) . $order->tripUrlSegment() }}">Change Items</a>
            </div>
        @endif

        <table class="table-tight table-items">
            <thead>
            <tr>
                <th style="width: 70%;">Item</th>
                <th>&nbsp;</th>
                <th class="text-right">Amount</th>
            </tr>
            </thead>
            <tbody>
            @if($order->isTravel())
                @include('orders._items-perdiem')
            @endif

            @foreach($order->items as $item)

                <tr>
                    <td>{{ $item->nameQtyAmount() }}</td>
                    <td><external-link link="{{ $item->url }}"></external-link></td>
                    <td class="text-right">${{ $item->lineTotal() }}</td>
                </tr>

            @endforeach

                <tr class="table-items__total">
                    <td colspan="2">Total</td>
                    <td>${{ $order->itemsTotalAmount() }}</td>
                </tr>

            </tbody>
        </table>

    @else
        @if($canEdit)
            <p><a href="{{ route('items', $order->id) }}">&plus; Items</a></p>
        @endif
    @endif
</section>
