<?php

if (isset($order) && $order->assigned_to) {
    $htmlContact = 'Contact: ' . eFirstLast($order->assignee);
} else {
    $htmlContact = '<span class="empty">No fiscal contact</span>';
}

?>
@if($canEdit->contact)

    <a href="{{ route('fiscal', $order->id) }}" class="js-order-refresh--assigned">
        {!! $htmlContact !!}
    </a>

    <on-call url="{{ route('on-call-api', $order->id) }}" class="js-order-refresh--oncall" ></on-call>

@else

    <span class="color-indigo-700 js-order-refresh--assigned">{!! $htmlContact !!}</span>

@endif
