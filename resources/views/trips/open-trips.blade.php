@extends('layout.default')
@section('title', 'Open Trips')
@section('content')
    <div class="panel panel-ribbon mw-1000">

    <h1 class="mb-3">New Travel Reimbursement</h1>

    <section class="my-4">
        <div class="font-weight-bold mb-2">You Have Open Trips!</div>

        <p>
            You have trips where you have completed a Pre-Authorization, but have not yet requested
            Reimbursement.
        </p>

        <p>
            If this request applies to one of the following trips click the item below and add a
            Reimbursement request to the existing trip. (This will keep your Pre-Authorization
            linked and save you repetitive data entry.)
        </p>
    </section>

    @if (count($projects) > 0)

        <div class="panel-full-width mb-5">
            <table class="table-tight sortable">
                <thead>
                <tr>
                    <th style="width: 8rem;">Project #</th>
                    <th style="width:25%;">Trip Dates</th>
                    <th>Title</th>
                    <th style="width:25%;">Traveler</th>
                </tr>
                </thead>
                <tbody>
                @foreach($projects as $project)

                    <tr>
                        <td><a href="{{ route('project', [$project->id, 'add']) }}" class="js-link-row">@projectNumber($project)</a></td>
                        <td>
                            <div>{{ eDate($project->trip->return_at) }} &mdash; {{ eDate($project->trip->return_at) }}</div>
                        </td>
                        <td>
                            <div><a href="{{ route('project', [$project->id, 'add']) }}" class="js-link-row">{{ $project->title }}</a></div>
                            <div class="text-sm text-muted">{{ $project->trip->destination }}</div>
                        </td>
                        <td>
                            {{ $project->trip->traveler }}
                        </td>
                    </tr>

                @endforeach

                </tbody>
            </table>
        </div>

    @else

        <div class="empty-table my-3">
            No matching trips.
        </div>

    @endif

        <section>
            <p>
                Or, if this is a Travel Reimbursement for a different trip, press the button to contine.
            </p>

            <div class="order-menu my-4 mw-400">
                <a class="order-menu__button" href="{{ route('project-create', \App\Workflows\OrderTypes::TRAVEL_REIMBURSEMENT) }}?new=1">
                    <span>@icon('plane-departure')</span> Travel Reimbursement - New Trip
                </a>
            </div>

        </section>
@stop
