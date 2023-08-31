@extends('layout.default')
@section('title', 'Delete Folders')
@section('content')
    <div class="panel-area container">
        <section class="panel">

            <h1>Delete Folders</h1>

            <div class="download_link">
                <a href="{{ downloadHref() }}">Download CSV spreadsheet</a>
            </div>

            <p>
                List of Projects and Trips that have been closed for 90 days. Old OneDrive folders must
                be deleted by the fiscal team. After you have deleted an old folder in OneDrive, mark
                it deleted here.
            </p>

            @if($report->count > 0)

                <div class="panel-full-width mb-5">
                    <table class="table-tight sortable">
                        <thead>
                        <tr>
                            <th style="width: 8rem;">Project #</th>
                            <th style="width:25%;">Dates</th>
                            <th>Title</th>
                            <th style="width:25%;">Project Closed</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($report->projects as $project)

                            @if($project->trip)

                                <tr>
                                    <td><a href="{{ route('delete-folder', $project->id) }}" class="js-link-row">@projectNumber($project)</a></td>
                                    <td>
                                        <div>{{ eDate($project->trip->return_at) }} &mdash; {{ eDate($project->trip->return_at) }}</div>
                                        <div class="text-sm text-muted">Travel Dates</div>
                                    </td>
                                    <td>
                                        <div><a href="{{ route('delete-folder', $project->id) }}" class="js-link-row">{{ $project->title }}</a></div>
                                        <div class="text-sm text-muted">{{ $project->trip->destination }}</div>
                                    </td>
                                    <td>
                                        <div>{{ eDate($project->closed_at) }}</div>
                                        <div class="text-sm text-muted">By {{ eFirstLast($project->closed_by) }}</div>
                                    </td>
                                </tr>

                            @else

                                <tr>
                                    <td><a href="{{ route('delete-folder', $project->id) }}" class="js-link-row">@projectNumber($project)</a></td>
                                    <td>
                                        <div>{{ eDate($project->created_at) }}</div>
                                        <div class="text-sm text-muted">Project created {{ $project->created_at->diffForHumans() }}</div>
                                    </td>
                                    <td>
                                        <a href="{{ route('delete-folder', $project->id) }}" class="js-link-row">{{ $project->title }}</a>
                                    </td>
                                    <td>
                                        <div>{{ eDate($project->closed_at) }}</div>
                                        <div class="text-sm text-muted">By {{ eFirstLast($project->closed_by) }}</div>
                                    </td>
                                </tr>

                            @endif

                        @endforeach

                        </tbody>
                    </table>
                </div>

            @else

                <div class="empty-table">
                    There are no projects with OneDrive folders ready to delete
                </div>

            @endif


        </section>
    </div>

@stop
