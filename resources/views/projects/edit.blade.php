@extends('layout.default')
@section('title', $order->typeName())
@section('content')
    <div class="page-with-help">
        <div class="page-with-help__content">
            <div class="page-with-help__form">
                <h1 class="mb-4">
                    {!! ($order->project_id) ? projectNumber($order, true) : '' !!} {{ $order->typeName() }}
                </h1>

                {!! $form->open(route('project-update', $order->id)) !!}

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
                <h2>Help: Edit the Project</h2>

                @if($order->type === 'purchase')
                    @include('projects._help-purchase')
                @elseif($order->type === 'reimbursement')
                    @include('projects._help-reimbursement')
                @elseif($order->type === 'invoice')
                    @include('projects._help-invoice')
                @else
                    @include('projects._help')
                @endif

            </div>
        </div>
    </div>
@stop
