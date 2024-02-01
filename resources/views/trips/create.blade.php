@extends('layout.default')
@section('title', $order->typeName())
@section('content')
    <div class="page-with-help">
        <div class="page-with-help__content">
            <div class="page-with-help__form">
                <h1 class="mb-4">{{ $order->typeName() }}</h1>

                {!! $form->open(route('project-store', $order->type)) !!}

                @include('trips._form')

                {!! $form->close() !!}
            </div>
            <div class="page-with-help__help">

                @include('trips._help', ['typeName' => $order->typeName()])
            </div>
        </div>
    </div>
@stop
