<div id="js-trip-form">
    @inputBlock('traveler_type', 'Traveler Affiliation')

    <div id="js-traveler-uaa">
        @input('person_id')
        @inputBlock('traveler_search', 'Traveler (UAA)')
    </div>

    <div id="js-traveler-other" class="panel-full-width p-panel bg-indigo-100 mb-3">
        <div class="text-sm-bold color-indigo-800 mb-3">TRAVELER</div>

        @inputBlock('traveler', 'Name')

        <div class="form-row-stretch">
            @inputBlock('traveler_email', 'Email')
            @inputBlock('traveler_phone', 'Phone')
        </div>

        <p>As a non UW Traveler, please enter the mailing address to which you should receive your reimbursement check.</p>
            @inputBlock('nuwt_address_line1', 'Address Line 1')
            @inputBlock('nuwt_address_line2', 'Address line 2')
            <div class="form-row-stretch">
            @inputBlock('nuwt_city', 'City')
            @inputBlock('nuwt_state_province', [
                
                    'label' => 'State/Province (2 characters code)',
                    'placeholder' => 'XX',
                    'minlength' => 2,
                    'maxlength' => 2,
                    'pattern' => '.{,2}'
                ])

            </div>

            <div class="form-row-stretch">
            @inputBlock('nuwt_zipcode', 'ZIP Code')
            @inputBlock('nuwt_country', 'Country')
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

    <div class="form-row-stretch">
       @inputBlock('destination', 'Destination')
       <div>
            <label class="form-group__label">State</label>
            <select class="form-control" id="state" name="state" onchange="return showdisclaimer();">
            <option value="">- Please select -</option>
            @foreach($states as $state)
                <option value="{{$state->name}}">{{$state->name}}</option>
            @endforeach
        </select>
    </div>
    </div>

    <div id="disclaimer" class="form-row-stretch" style="visibility:hidden">
       <div class="form-check">
       <input class="form-check-input" type="checkbox" name="overseas_disclaimer" id="overseas_disclaimer" >
            <label class="form-check-label" for="overseas_disclaimer">
                I confirm I have registered my overseas travel per <a target="_blank" href="https://www.washington.edu/globalaffairs/global-travelers/travelregistry/facstaff/">UW Guidance</a>
            </label>
       </div> 
    </div>

    
    <div class="form-row-stretch">
    @inputBlock('depart_at', [
    'id' => 'depart_at',
        'label' => 'Departure Date',
        'placeholder' => 'MM/DD/YYYY',
        'minlength' => 10,
        'maxlength' => 10
    ])
    
    @inputBlock('return_at', [
            'id' => 'return_at',
            'label' => 'Return Date',
            'placeholder' => 'MM/DD/YYYY',
            'minlength' => 10,
            'maxlength' => 10
    ])
    </div>
    

    @if($order->type == 'travel-pre-auth')
        <div class="form-row-stretch">
        @inputBlock('depart_at_time', [
            'id' => 'depart_at_time',
            'label' => 'Departure Time',
            'placeholder' => 'hh:mm AM',
            'pattern' => '(1[012]|0?[1-9]):[0-5][0-9] (am|pm|AM|PM)',
            'minlength' => 8,
            'maxlength' => 8
        ])
        
        @inputBlock('return_at_time', [
            'id' => 'return_at_time',
            'label' => 'Return Time',
            'placeholder' => 'hh:mm PM',
            'pattern' => '(1[012]|0?[1-9]):[0-5][0-9] (am|pm|AM|PM)',
            'minlength' => 8,
                'maxlength' => 8
        ])

        </div>
   @endif

    @inputBlock('purpose', [
        'label' => 'Description and Business Purpose',
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

@section('scripts')

<script type="text/javascript">
    function showdisclaimer(){
    var selectBox = document.getElementById('state');
    var userInput = selectBox.options[selectBox.selectedIndex].value;
    if (userInput == "International"){
    document.getElementById('disclaimer').style.visibility = 'visible';
        }else{
    document.getElementById('disclaimer').style.visibility = 'hidden';
    }
    return false;}

    </script>
@stop