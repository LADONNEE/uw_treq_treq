@extends('layout.default')
@section('title', 'Open Trips')
@section('content')
    <div class="panel-area container">
        <section class="panel">

            <h1>Open Trips</h1>

            <p>Trips that have a completed Pre-Authorization, return date is passed, and have not been Closed.</p>

            @include('home._table-trips', ['projects' => $report->projects])

        </section>
    </div>

@stop
