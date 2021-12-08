@extends('layout.default')
@section('title', $title)
@section('content')
    <div class="panel-area container">
        <div class="panel">
            <h1 class="mb-5">{{ $title }}</h1>

            <div class="download_link">
                <a href="{{ downloadHref() }}">Download CSV spreadsheet</a>
            </div>

            @include('home._table-status', [
                'orders' => $orders,
                'count' => count($orders),
            ])

        </div>
    </div>

@stop
