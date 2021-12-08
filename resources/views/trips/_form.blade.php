<div id="js-trip-form">
    @inputBlock('traveler_type', 'Traveler Affiliation')

    <div id="js-traveler-coe">
        @input('person_id')
        @inputBlock('traveler_search', 'Traveler (College of Education)')
    </div>

    <div id="js-traveler-other" class="panel-full-width p-panel bg-indigo-100 mb-3">
        <div class="text-sm-bold color-indigo-800 mb-3">TRAVELER</div>

        @inputBlock('traveler', 'Name')

        <div class="form-row-stretch">
            @inputBlock('traveler_email', 'Email')
            @inputBlock('traveler_phone', 'Phone')
        </div>


        <div id="js-honorarium">
            <div class="form-group--boolean">
                @input('has_honorarium', 'Honorarium')
            </div>

            <div id="js-honorarium-amount">
                @inputBlock('honorarium', 'Honorarium Amount')
            </div>
        </div>
    </div>

    @inputBlock('destination', 'Destination')

    <div class="form-row-stretch">
        @inputBlock('depart_at', 'Departure Date')
        @inputBlock('return_at', 'Return Date')
    </div>

    @inputBlock('purpose', [
        'label' => 'Business Purpose',
        'rows' => 5
    ])

    @inputBlock('personal_time', 'Personal Time')

    <div id="js-personal-time-dates">
        @inputBlock('personal_time_dates', [
            'label' => 'Personal Time Dates',
            'help' => 'Dates during trip that are personal time (Required)'
        ])
    </div>

    <div class="my-4">
        <button class="btn btn-primary">Save &amp; Continue</button>
    </div>
</div>
