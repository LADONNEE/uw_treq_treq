@extends('layout.default')
@section('title', 'Food Orders')
@section('content')
    <div class="panel-area container">
        <section class="panel">

            <h1>Food Orders</h1>

            <p>
                Orders where user indicated food purchase.
            </p>

            @include('home._table-status', ['orders' => $report->orders])

        </section>
    </div>

@stop
