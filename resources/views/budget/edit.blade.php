@extends('layout.default')
@section('title', 'Budgets')
@section('content')
    <div class="panel panel-ribbon mw-1200">

        @include('orders/_header')

        <h2 class="mb-4">Budgets</h2>

        <form action="{{ route('budgets-update', $order->id) }}" method="post">
            {!! csrf_field() !!}

            <budget-tool
                order_id="{{ $order->id }}"
                state-uri="{{ route('budgets-api-state', $order->id) }}"
                complete-url="/treq"
            ></budget-tool>
        </form>

        @include('orders._cancel-option')
    </div>
@stop
