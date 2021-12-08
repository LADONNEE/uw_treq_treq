@extends('layout.default')
@section('title', 'RSP Orders')
@section('content')
    <div class="panel-area container">
        <section class="panel">

            <h1>Research Subject Payments</h1>

            <p>
                Orders where user indicated research subject payments using revolving fund checks. (Separate
                report available for <a href="{{ route('reports', 'gift-cards') }}">RSP Using Gift Cards</a>).
            </p>

            @include('home._table-status', ['orders' => $report->orders])

        </section>
    </div>

@stop
