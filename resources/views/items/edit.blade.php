@extends('layout.default')
@section('title', $order->typeName())
@section('content')
    <div class="panel panel-ribbon mw-800">
        @include('orders/_header')

        <h2>Items</h2>

        <form action="{{ route('items-update', $order->id) }}" method="post">
            {!! csrf_field() !!}

            <items-input
                    tax-rate="{{ setting('seattle-sales-tax') }}"
                    state-uri="{{ route('items-api-state', $order->id) . $order->tripUrlSegment() }}"
            ></items-input>

            <div class="my-4">
                <button class="btn btn-primary">Save &amp; Continue</button>
            </div>
        </form>

        <hr class="my-4">

        <div class="note__row">
            <notes-section id="{{ $order->id }}" section="items"></notes-section>
        </div>

        @include('orders._cancel-option')
    </div>
@stop
