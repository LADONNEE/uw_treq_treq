@extends('layout/default')
@section('title', 'Search Orders')
@section('content')
    <div class="panel panel-ribbon mw-1200">
    <h1>Search Orders</h1>

    <form method="get" action="{!! route('search') !!}">
        <div class="search-form-large input-group">
            <input type="text" name="q" id="search-query" class="form-control" value="{{ $searchTerm }}" />
            <div class="input-group-append">
                <button class="btn btn-primary" type="submit">Search</button>
            </div>
        </div>
    </form>
    <a class="advanced-search-link" href="{{route('advanced-search')}}">Advanced</a>

    @if (count($orders) > 0)

        <h2 class="text-lg my-3">Orders</h2>

        @include('home._table-status')

    @endif

    @if (count($projects) > 0)

        <h2 class="text-lg my-3">Projects</h2>

        <div class="panel-full-width mb-5">
        <table class="table-tight sortable">
            <thead>
            <tr>
                <th style="width: 8rem;">Project #</th>
                <th style="width:25%;">Created</th>
                <th>Title</th>
                <th style="width:25%;">Owner</th>
            </tr>
            </thead>
            <tbody>
            @foreach($projects as $project)

                <tr>
                    <td><a href="{{ route('project', $project->id) }}" class="js-link-row">@projectNumber($project)</a></td>
                    <td>{{ eDate($project->created_at) }}</td>
                    <td><a href="{{ route('project', $project->id) }}" class="js-link-row">{{ $project->title }}</a></td>
                    <td>{{ eFirstLast($project->person_id) }}</td>
                </tr>

            @endforeach

            </tbody>
        </table>
        </div>

    @endif

    @if (count($trips) > 0)

        <h2 class="text-lg my-3">Trips</h2>

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
            @foreach($trips as $trip)

                <tr>
                    <td><a href="{{ route('project', $trip->project_id) }}" class="js-link-row">@projectNumber($trip->project)</a></td>
                    <td>
                        <div>{{ eDate($trip->depart_at) }} &mdash; {{ eDate($trip->return_at) }}</div>
                    </td>
                    <td>
                        <div><a href="{{ route('project', $trip->project_id) }}" class="js-link-row">{{ $trip->project->title }}</a></div>
                        <div class="text-sm text-muted">{{ $trip->destination }}</div>
                    </td>
                    <td>
                        {{ $trip->traveler }}
                    </td>
                </tr>

            @endforeach

            </tbody>
        </table>
        </div>

    @endif

    @if (count($budgets) > 0)

        <h2 class="text-lg my-3">Budgets</h2>

        <div class="panel-full-width mb-5">
        <table class="table-tight sortable">
            <thead>
            <tr>
                <th style="width: 8rem;">Project #</th>
                <th>Submitted</th>
                <th>Project</th>
                <th>Stage</th>
                <th>Budget Number</th>
                <th>Split</th>
            </tr>
            </thead>

            <tbody>
            @foreach ($budgets as $budget) <?php $order = $budget->order; ?>

                <tr>
                    <td><a href="{{ route('order', $order->id) }}" class="js-link-row">@projectNumber($order)</a></td>
                    <td>
                        <div>{{ eDate($order->submitted_at) }}</div>
                        <div class="text-sm text-muted">{{ eFirstLast($order->submitter) }}</div>
                    </td>
                    <td>
                        <div><a href="{{ route('order', $order->id) }}" class="js-link-row">{{ $order->project->title }}</a></div>
                        <div class="text-sm text-muted">{{ $order->typeName() }}</div>
                    </td>
                    <td>{{ $order->stage }}</td>
                    <td>{{ $budget->budgetno }} <span style="color: #999;">{{ $budget->pca_code }}</span></td>
                    <td>{{ $budget->splitDescription() }}</td>
                </tr>

            @endforeach
            </tbody>
        </table>
        </div>

    @endif

    @if (count($aribas) > 0)

        <h2 class="text-lg my-3">Fiscal Ref #</h2>

        @include('home._table-status', ['orders' => $aribas])

    @endif

    <hr class="mt-4">

    <h2 class="my-4">Search Help</h2>

    <article class="help">

        <p>TREQ matches your search against projects, trips, and budgets by searching the following fields.</p>

        <h3 class="text-med mt-3">Orders</h3>
        <ul class="bullet">
            <li>Submitter name or UW NetID</li>
        </ul>

        <h3 class="text-med mt-3">Projects</h3>
        <ul class="bullet">
            <li>TREQ Project Number - "TREQ000123" or "123"</li>
            <li>Title</li>
        </ul>

        <h3 class="text-med mt-3">Trips</h3>
        <ul class="bullet">
            <li>Destination</li>
            <li>Traveler</li>
        </ul>

        <h3 class="text-med mt-3">Budgets</h3>
        <ul class="bullet">
            <li>Budget number (XX-XXXX)</li>
            <li>Budget name</li>
            <li>PCA Code</li>
        </ul>

    </article>

    </div>
@stop
