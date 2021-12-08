@extends('layout/default')
@section('title', 'Cancel Order')
@section('content')
    <div class="panel panel-ribbon mw-600">

    @include('orders/_header')

    <h2>Cancel Order</h2>

    <form action="{{ route('cancel-order-update', $order->id) }}" method="post">
        {!! csrf_field() !!}

        <div class="js-confirm-dialog row my-3">
            <div class="js-confirm-dialog--home col-12">
                <div class="alert alert-secondary">
                    Cancel an order if it is no longer needed. Canceled requests will be removed
                    from workflow, but can be looked up in search and reports.
                </div>
                <br>
                <a href="{{ route('order', $order->id) }}" class="btn btn-secondary">Keep this Order</a>
                <button class="btn btn-danger js-confirm-dialog--show" data-focus="cancel_note_input">Cancel Order...</button>
            </div>
            <div class="js-confirm-dialog--confirm col-12" style="display:none;">
                <div class="form-group">
                    <label for="cancel_note_input" class="form-group__label">
                        Why is this order being canceled?
                    </label>
                    <textarea name="note" id="cancel_note_input" class="form-control phrase" rows="3"></textarea>
                </div>
                <div class="input_row">
                    <button type="submit" class="btn btn-secondary js-confirm-dialog--cancel">&lt; Go back</button>
                    <button type="submit" class="btn btn-danger">Confirm Canceled</button>
                </div>
            </div>
        </div>

    </form>

    @if(hasRole('delete'))

        <hr class="my-5">

        <div class="row">
            <div class="col">
                <p>
                    As an administrator in this system you have the option to completely delete this order.
                </p>
                <p>
                    Cancel is generally the right action for orders that were started and users have acted on.
                    Cancel will resolve the order, but the history can be viewed through search and within the
                    project.
                </p>
                <p>
                    Use delete when a request was created in error and there is no user interactions that should
                    be preserved.
                </p>
                <label class="checkbox-label">
                    <input type="checkbox" value="1" class="js-show-when-checked" data-target="js-delete-form">
                    Delete completely...
                </label>
            </div>
        </div>

        <div class="row my-5" style="display:none;" id="js-delete-form">
            <div class="col">
                <form action="{{ route('cancel-order-destroy', $order->id) }}" method="post">
                    {!! csrf_field() !!}
                    <button class="btn btn-danger" type="submit">Confirm Delete Completely</button>
                </form>
            </div>
        </div>

    @endif
    </div>
@stop
