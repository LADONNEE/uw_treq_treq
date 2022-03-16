@extends('layout.default')
@section('title', $order->typeName())
@section('content')
    <div class="panel panel-ribbon mw-800">

        @include('orders/_header')

        <h2 class="mb-4 pb-2 border-bottom">Travel Items</h2>

        <h3>Travel Per Diem Rates</h3>

        <p>
            Per Diem reimbursement rates for travel lodging and meals is set per destination
            by the U.S. General Services Administration (US GSA).
        </p>

        <p class="mb-3">
            <a href="{{ $usgsaUrl }}" target="_perdiem" class="font-weight-bold">Per Diem Rates</a> @bar
            <a href="https://finance.uw.edu/travel/perdiem" target="uw_travel" class="font-weight-light">UW Travel Policy</a>
        </p>

        <p>
            Nights of lodging and days of meals is based on travel dates of departure {{ eDate($order->project->trip->depart_at) }},
            return {{ eDate($order->project->trip->return_at) }}. Subtract any personal days.
        </p>

        <form action="{{ route('trip-items-update', $order->id) }}" method="post">
            {!! csrf_field() !!}


            <div class="my-4">
                <per-diem state-uri="{{ route('perdiem-api-state', $order->id) }}">
                    <template v-slot:lodging>
                        <ul class="per-diem__instructions">
                            <li>Enter number of nights at lodging</li>
                            <li>Look up rate for your destination on <a href="{{ $usgsaUrl }}" target="_perdiem">US GSA website</a></li>
                            <li>Enter US GSA Per Diem rate for Lodging (daily limit for your destination and month of travel)</li>
                            <li>Enter your Actual Lodging (or expected) total for all nights</li>
                            <li>You will be reimbursed for your actual lodging expenses</li>
                            <li>You must provide receipts for lodging reimbursement</li>
                            <li>
                                Your Actual Lodging reimbursement MAY NOT exceed the Lodging Limit except
                                <a href="https://finance.uw.edu/travel/perdiem#exceptionstoperdiem" target="uw_travel">special cases</a>
                            </li>
                            <li>Exceptions to Lodging Limit must have a pre-authorizations</li>
                        </ul>
                    </template>

                    <template v-slot:meals>
                        <ul class="per-diem__instructions">
                            <li>Enter number of days of travel</li>
                            <li>Look up rate for your destination on <a href="{{ $usgsaUrl }}" target="_perdiem">US GSA website</a></li>
                            <li>Enter US GSA Per Diem rate for Meals (M&IE Total)</li>
                            <li>Meals Total is an estimate based on per diem x days</li>
                            <li>No receipts are needed for meals &amp; incidentals</li>
                            <li>You will be reimbursed per diem prorated by travel status</li>
                        </ul>
                    </template>
                </per-diem>
            </div>

            <h3>Other Items</h3>

            <items-input state-uri="{{ route('items-api-state', $order->id) . '/trip' }}"></items-input>


            <div class="mt-5">
                <button class="btn btn-primary">Save &amp; Continue</button>
            </div>
        </form>

        <hr class="my-4">

        <div class="note__row">
            <notes-section id="{{ $order->id }}" section="items"></notes-section>
        </div>

        @include('orders._cancel-option')
    </div>
@stop
