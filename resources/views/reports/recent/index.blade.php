@extends('layout.default')
@section('title', 'Recent Orders')
@section('content')
    <div class="panel-area container">
        <section class="panel">

            <h1>Recent Orders</h1>

            <div class="download_link">
                <a href="{{ downloadHref() }}">Download CSV spreadsheet</a>
            </div>

            <p>Orders that are Complete or Canceled in the last 30 days.</p>

            @include('home._table-status', ['orders' => $report->orders])

        </section>
    </div>

@stop
