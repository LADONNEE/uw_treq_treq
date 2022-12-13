@extends('layout.default')
@section('title', 'Assign Fiscal')
@section('content')

    <section class="mt-5 mw-600 mx-auto">
        <h1>Assign Fiscal</h1>

        <div class="alert alert-info my-3">
            Specify who will provide the initial authorizer approval. This will be an Associate Dean, Area
            Chair, PI, or program director who has authority over project and the relevant budgets.
        </div>

        {!! $form->open(route('fiscal-update', $order->id)) !!}

        @input('person_id')
        @inputBlock('assign_search', 'Assign Fiscal')

        <div class="my-4">
            <button type="submit" class="btn btn-primary">Assign</button>
        </div>

        {!! $form->close() !!}
    </section>

@stop
