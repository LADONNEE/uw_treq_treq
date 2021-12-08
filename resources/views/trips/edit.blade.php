@extends('layout.default')
@section('title', $order->typeName())
@section('content')
    <div class="page-with-help">
        <div class="page-with-help__content">
            <div class="page-with-help__form">

                <h1 class="mb-4">
                    {!! ($order->project_id) ? projectNumber($order, true) : '' !!} {{ $order->typeName() }}
                </h1>

                {!! $form->open(route('trip-update', $order->id)) !!}

                @include('trips._form')

                {!! $form->close() !!}

            </div>
            <div class="page-with-help__help">
                <h2>Help: Edit the Trip</h2>

                @include('trips._help')
            </div>
        </div>
    </div>
@stop
