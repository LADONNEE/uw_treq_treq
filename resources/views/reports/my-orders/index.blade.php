@extends('layout.default')
@section('title', 'My Orders')
@section('content')
    <div class="panel-area container">
        <section class="panel">

            <h1>My Orders</h1>

            <div class="download_link">
                <a href="{{ downloadHref() }}">Download CSV spreadsheet</a>
            </div>

            <p>
                Orders you submitted or are the owner of that are still pending action or were resolved
                in the last two years.
            </p>

            @include('home._table-status', ['orders' => $report->orders])

        </section>
    </div>
@stop
