@extends('layout.default')
@section('title', $order->typeName())
@section('content')
    <div class="panel panel-ribbon mw-800">

        @include('orders/_header')

        <h2 class="my-4 pb-2 border-bottom">Post Travel Notes</h2>

        <p class="mb-4">
            Following questions help highlight any adjustments or special circumstances that impact
            your travel reimbursement.
        </p>

        {!! $form->open(route('trip-notes-update', $order->id)) !!}

        @foreach($form->itemNames as $item)
            @include('trip-notes._question', [
                'question' => $form->input($item),
                'note' => $form->input("{$item}_note"),
            ])
        @endforeach

        <div class="my-4">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>

        {!! $form->close(); !!}
    </div>
@stop
