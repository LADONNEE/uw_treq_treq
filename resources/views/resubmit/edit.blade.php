@extends('layout.default')
@section('title', 'Re-Submit Order')
@section('content')
    <div class="panel panel-ribbon mw-600">

        <h2>Re-Submit Order</h2>

        <div class="alert alert-info my-4">
            After you have made the requested adjustments to your order, addressing the reason
            this was sent back, re-submit your order.<br>
            <br>
            Order will be routed to the fiscal contact for review of adjustments and further
            action.
        </div>

        @include('department._preview', [])

        <section class="mt-5">
            {!! $form->open(route('resubmit-update', $order->id)) !!}

            @inputBlock('description', [
            'label' => 'Re-Submit Note',
            'rows' => 4,
            'help' => '(Optional) Add a note for your fiscal contact if adjustments need additional explanation.',
            ])

            <div class="my-4">
                <button type="submit" class="btn btn-primary">Re-Submit</button>
            </div>

            {!! $form->close() !!}
        </section>
    </div>

@stop
