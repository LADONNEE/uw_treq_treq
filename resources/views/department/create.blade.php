@extends('layout.default')
@section('title', 'Authorizer Approval')
@section('content')
<?php
$project = $project ?? $order->project;
?>
    <div class="panel panel-ribbon mw-600">

        <h2>Authorizer Approval</h2>

        <div class="alert alert-info my-4">
            <p class="text-lg mt-0">Review &amp; Submit</p>

            <p>
                Review your request to ensure it is complete and accurate, then submit it to
                start the review and approval workflow.
            </p>
        </div>

        @include('department._preview')

        <section class="mt-5">
            <h2 class="mb-4">Authorizer Approval</h2>

            {!! $form->open(route('department-store', $order->id)) !!}

            <fieldset class="form-group">
                <div class="form-check">
                    <input class="form-check-input js-approval-from--radio" data-target="js-approval-from--other-form"
                           type="radio" name="approval_from" id="approval_from_other" value="other" checked>
                    <label class="form-check-label" for="approval_from_other">
                        Send to Authorizer
                    </label>
                </div>
                
                @if(!$project->is_travel && ($order->type != 'reimbursement') )
                    <div class="form-check">
                        <input class="form-check-input js-approval-from--radio" data-target="js-approval-from--self-form"
                            type="radio" name="approval_from" id="approval_from_self" value="self">
                        <label class="form-check-label" for="approval_from_self">
                            Approve this Myself (if you are the Director or Associate Dean)
                        </label>
                    </div>
                @endif

            </fieldset>

            <div class="js-approval-from--section" id="js-approval-from--other-form">
                <div class="alert alert-info my-3">
                    <div class="font-weight-bold mb-2">Send to Authorizer</div>
                    <div>
                    @if($project->is_travel  || ($order->type == 'reimbursement'))
                        Specify who will provide the initial authorizer approval.
                    @else
                        Specify who will provide the initial authorizer approval.
                    @endif

                    </div>
                </div>

                @input('person_id')
                @inputBlock('approver', 'Authorizer')
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
                        If you are the Director or Associate Dean overseeing the relevant budgets, you do not need approval. Click the submit button.
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
