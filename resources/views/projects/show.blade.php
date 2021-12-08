@extends('layout.default')
@section('title', $project->pageTitle())
@section('content')
    <div class="order-show panel-area">
        <div class="order-show__title">
            <div class="float-right">
                <a href="{{ route('print-project', $project->id) }}">@icon('print') Print</a>
            </div>
            <h1>@projectNumber($project) {{ $project->title }}</h1>
        </div>

        <div class="order-show__project">
            @if($project->is_travel)
                @include('trips._summary')
            @else
                @include('projects._summary')
            @endif
            @include('projects._files')
        </div>

        <div class="order-show__orders">
            @foreach($project->orders as $o)
                @include('orders._order-collapsed', ['order' => $o])
            @endforeach

            <section>
                <div class="mb-3">
                    @include('projects._project-buttons')
                </div>
                <div id="js-add-order" {!! ($adding) ? '' : 'style="display: none;"' !!}>
                    @include('projects._new-order')
                </div>
            </section>
        </div>

    </div>
@stop
