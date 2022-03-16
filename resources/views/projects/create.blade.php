@extends('layout.default')
@section('title', $order->typeName())
@section('content')
    <div class="page-with-help">
        <div class="page-with-help__content">
            <div class="page-with-help__form">
                <div class="text-sm-bold text-gray">Create New Order</div>
                <h1 class="mb-4">{{ $order->typeName() }}</h1>

                {!! $form->open(route('project-store', $order->type)) !!}


                @if($order->type === 'purchase')
                    @include('projects._form-purchase')
                @elseif($order->type === 'reimbursement')
                    @include('projects._form-reimbursement')
                @elseif($order->type === 'invoice')
                    @include('projects._form-invoice')
                @else
                    @include('projects._form')
                @endif


                {!! $form->close() !!}
            </div>
            <div class="page-with-help__help">

                @if($order->type === 'purchase')
                    <h2>Help: Create a Request to Purchase Project </h2>
                    @include('projects._help-purchase')
                @elseif($order->type === 'reimbursement')
                    <h2>Help: Request a Reimbursement Project </h2>
                    @include('projects._help-reimbursement')
                @elseif($order->type === 'invoice')
                    <h2>Help: Pay an Invoice Project </h2>
                    @include('projects._help-invoice')
                @else
                    <h2>Help: Create a Project </h2>
                    @include('projects._help')
                @endif

            </div>
        </div>
    </div>
@stop


