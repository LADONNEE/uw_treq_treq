@extends('layout.default')
@section('title', 'Department Approval')
@section('content')
    <div class="panel panel-ribbon mw-600">

        <h2>Department Approval</h2>

        <div class="alert alert-info my-4">
            <p class="text-lg mt-0">Review &amp; Submit</p>

            <p>
                Review your request to insure it is complete and accurate, then submit it to
                start the review and approval workflow.
            </p>
        </div>

        @include('department._preview')

        <section class="mt-5">
            <h2 class="mb-4">Department Approval</h2>

            {!! $form->open(route('department-store', $order->id)) !!}

            <fieldset class="form-group">
                <div class="form-check">
                    <input class="form-check-input js-approval-from--radio" data-target="js-approval-from--other-form"
                           type="radio" name="approval_from" id="approval_from_other" value="other" checked>
                    <label class="form-check-label" for="approval_from_other">
                        Send to Department Approver
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input js-approval-from--radio" data-target="js-approval-from--self-form"
                           type="radio" name="approval_from" id="approval_from_self" value="self">
                    <label class="form-check-label" for="approval_from_self">
                        Approve this Myself
                    </label>
                </div>
            </fieldset>

            <div class="js-approval-from--section" id="js-approval-from--other-form">
                <div class="alert alert-info my-3">
                    <div class="font-weight-bold mb-2">Send to Department Approver</div>
                    <div>
                        Specify who will provide the initial department approval. This will be a PI, Director,
                        Area Chair, or Dean who has authority over project and the relevant budgets.
                    </div>
                </div>

                @input('person_id')
                @inputBlock('approver', 'Department Approver')
                @inputBlock('description', [
                    'label' => 'Approver Note',
                    'rows' => 3,
                    'help' => '(Optional) Add a note if this project needs additional explanation for the approver.',
                ])
            </div>

            <div class="js-approval-from--section" id="js-approval-from--self-form" style="display: none;">
                <div class="alert alert-info my-3">
                    <div class="font-weight-bold mb-2">Approve this Myself</div>
                    <div>
                        Give department approval and send to fiscal. Use this when you are the PI/Director of
                        the relevant budgets or when you have spending authority for a specific request (example:
                        faculty professional development budgets).
                    </div>
                </div>
            </div>

            <div class="my-4">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>

            {!! $form->close() !!}
        </section>

        @include('orders._cancel-option')
    </div>

@stop
