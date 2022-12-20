@extends('layout.default')
@section('title', 'Submit Order')
@section('content')
    <div class="panel panel-ribbon mw-600">

        <h2>Submit Order</h2>

        <div class="alert alert-info my-4">
            <p class="text-lg mt-0">Review &amp; Submit</p>

            <p>
                Review your request to ensure it is complete and accurate, then submit it to
                start the review and approval workflow.
            </p>
        </div>

        @include('department._preview')

        <section class="mt-5">
            <h2 class="mb-4">Send Order to Fiscal</h2>

            <div class="alert alert-info my-3">
                This project includes a Pre-Authorization which has Spend Authorizer Approval, that step is complete.
                After reviewing and verifying your order, send to fiscal for handling.
            </div>

            @include('tasks._task', ['task' => $approval])

            <form action="{{ route('department-update', $order->id) }}" method="post">
                {!! csrf_field() !!}
                <div class="my-4">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </section>

        @include('orders._cancel-option')
    </div>

@stop
