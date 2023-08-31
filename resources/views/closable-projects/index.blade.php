@extends('layout.default')
@section('title', 'Closable Projects')
@section('content')
    <div class="panel-area container">
        <section class="panel">

            <h1>Closable Projects</h1>

            <div class="download_link">
                <a href="{{ downloadHref() }}">Download CSV spreadsheet</a>
            </div>

            <p>
                List of Projects and Trips that have no pending orders and travel dates have passed.
            </p>

            @include('reports._table-projects-and-trips', [
                'projects' => $report->projects,
                'empty' => 'No closable projects or trips',
            ])

        </section>
    </div>

@stop
