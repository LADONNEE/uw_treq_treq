@extends('layout.default')
@section('title', 'Travel & Requisitions')
@section('content')
    <div class="py-5 bg-white">
        <div class="container mw-1000">

            <div class="float-right text-right">
                <a href="{{ route('help', 'about') }}">About TREQ</a> @bar
                <a href="{{ route('order-types') }}">Help Order Types</a>
            </div>

            <h1>Travel &amp; Requisitions</h1>

            <div class="order-menu my-4">
                @foreach($types as $type)
                    <a class="order-menu__button" href="{{ route('project-create', $type->slug) }}">
                        <span>@icon($type->icon)</span> {{ $type->name }}
                    </a>
                @endforeach
            </div>

        </div>
    </div>

    @include('home._jump-nav')

    <div class="panel-area container">

    <div class="panel">

        @includeWhen($reports->tasks->count > 0, 'home._needs-action', [
            'orders' => $reports->tasks->orders,
            'count' => $reports->tasks->count,
        ])

        @includeWhen($reports->creating->count > 0, 'home._creating', [
            'orders' => $reports->creating->orders,
            'count' => $reports->creating->count,
        ])

        @include('home._my-orders', [
            'orders' => $reports->myOrders->orders,
            'count' => $reports->myOrders->count,
        ])

        @includeWhen($reports->myTrips->count > 0, 'home._my-trips', [
            'projects' => $reports->myTrips->projects,
            'count' => $reports->myTrips->count,
        ])

    </div>

    @if(hasRole('treq:fiscal'))

        <div class="panel mt-4">

            <p class="text-sm text-muted pb-3 border-bottom">
                This section is for the fiscal team and includes orders submitted by all users.
                Shown to users with Fiscal role.
            </p>

            @include('home._on-call', [
                'orders' => $reports->pending->orders,
                'count' => $reports->pending->count,
            ])

            @include('home._pending', [
                'orders' => $reports->pending->orders,
                'count' => $reports->pending->count,
                'countDepartment' => $reports->pending->countDepartment,
                'countBudget' => $reports->pending->countBudget,
                'countTask' => $reports->pending->countTask,
            ])

        </div>

    @endif

    </div>

@stop
