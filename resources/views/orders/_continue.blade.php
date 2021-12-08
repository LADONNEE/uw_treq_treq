<div class="col-12 mb-4">
    @if($order->isSentBack())
        <div class="p-3 bg-red-200 color-red-900">
            <div class="text-lg mb-2">Sent Back</div>
            <div>
                Your order was sent back by an approver. Review the approver's message, make adjustments,
                and then
                <a href="{{ route('resubmit', $order->id) }}">re-submit the order</a>.
            </div>
        </div>
    @else
        <div class="p-3 bg-indigo-200 color-indigo-900">
            <div class="text-lg mb-2">Not Submitted</div>
            <div>
                This order is still being created. It needs to be completed and submitted for approval.
                <a href="{{ route('next', $order->id) }}">Continue creating order</a>.
            </div>
        </div>
    @endif
</div>
