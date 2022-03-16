@extends('layout.default')
@section('title', $order->typeName())
@section('content')
    <div class="page-with-help">
        <div class="page-with-help__content">
            <div class="page-with-help__form">
                <div class="text-sm-bold text-gray">Create New Order</div>
                <h1 class="mb-4">{{ $order->typeName() }}</h1>

                {!! $form->open(route('project-store', $order->type)) !!}

                @include('projects._form')

                {!! $form->close() !!}
            </div>
            <div class="page-with-help__help">
                <h2>Help: Create a Request to Purchase Project </h2>

                @if($order->type === 'purchase')
                    @include('projects._help-purchase')
                @elseif($order->type === 'pre-auth')
                    @include('projects._help')
                @elseif($order->type === 'reimbursement')
                    @include('projects._help')
                @elseif($order->type === 'invoice')
                    @include('projects._help')
                @else
                    @include('projects._help')
                @endif

            </div>
        </div>
    </div>
@stop


