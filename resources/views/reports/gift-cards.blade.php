@extends('layout.default')
@section('title', 'Gift Cards')
@section('content')
    <div class="panel-area container">
        <section class="panel">

            <h1>Gift Cards</h1>

            <p>
                Orders where user indicated research subject payments using gift cards. (Separate
                report available for <a href="{{ route('reports', 'rsp-orders') }}">RSP Using Revolving Fund Checks</a>).
            </p>

            @include('home._table-status', ['orders' => $report->orders])

        </section>
    </div>

@stop
