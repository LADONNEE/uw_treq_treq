@extends('layout.default')
@section('title', $project->pageTitle())
@section('content')
    <div class="order-show panel-area">
        <div class="order-show__title">
            <div class="float-right">
                <a href="{{ route('print', $order->id) }}">@icon('print') Print</a>
            </div>
            <h1>@projectNumber($project) {{ $project->title }}</h1>
        </div>

        <div class="order-show__project">
            @if($project->is_travel)
                @include('trips._summary')
            @else
                @include('projects._summary')
            @endif

            <section class="mt-5">
                <h2 class="text-lg">Attachments</h2>

                @include('attachments._file-buttons')

                <p><a href="{{ route('attachments', $order->id) }}">Attachments Help</a></p>

                @if(isset($order) && hasRole('treq:fiscal'))
                    <p><a href="{{ route('folder', $order->id) }}">Change OneDrive Folder</a></p>
                @endif
            </section>
        </div>

        <div class="order-show__orders">
            <div class="panel mb-3">
                @include('orders._order')
            </div>

            @foreach($project->orders as $o)
                @if($o->id != $order->id)
                    @include('orders._order-collapsed', ['order' => $o])
                @endif
            @endforeach

            <div class="js-order-refresh--project-buttons js-toggle-target--container">
                @include('projects._project-buttons')
            </div>
        </div>
    </div>
@stop
