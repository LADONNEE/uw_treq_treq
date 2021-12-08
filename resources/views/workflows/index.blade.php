@extends('layout/default')
@section('title', 'Workflows')
@section('content')
    <div class="panel panel-ribbon mw-1000">

        <h1>Workflows</h1>

        <article class="mb-5">
            <p>
                This page shows the workflow configuration for each Order Type in TREQ. Each Order
                Type has two workflows associated with it.
            </p>

            <p>
                The <strong>Request Steps</strong> configuration shows the required steps a
                requester must go through to create a complete order ready for review and
                processing.
            </p>

            <p>
                The <strong>Processing Steps</strong> configuration shows the steps completed
                by other users (approvers and the fiscal team) after the order has been
                submitted.
            </p>

            <p>
                Any Order Type might optionally move through or end up in one of the following
                global Processing Steps.
            </p>

            <ul class="bullet ml-5">
                <li>Creating</li>
                <li>Sent Back</li>
                <li>Resubmitted</li>
                <li>Needs Approval</li>
                <li>Pending Task</li>
                <li>Complete</li>
                <li>Canceled</li>
            </ul>
        </article>

        @foreach($types as $type)

            <section class="mb-5">
                <h2 class="mb-3 pt-3 border-top"><span>@icon($type->icon)</span> {{ $type->name }}</h2>

                <div class="container ml-5">
                    <div class="row">
                        <div class="col-md">
                            <h3>Request Steps</h3>

                            <ul class="ml-3">
                                @foreach($workflows[$type->slug]['request-steps'] as $step)
                                    <li>{{ ucfirst($step) }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="col-md">
                            <h3>Processing Steps</h3>

                            <ul class="ml-3">
                                @foreach($workflows[$type->slug]['process-steps'] as $step)
                                    <li>{{ $step }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </section>

        @endforeach
    </div>
@stop
