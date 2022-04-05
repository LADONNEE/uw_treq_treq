<div class="text-right text-sm-bold">
    <a href="{{ route('trip-edit', $order->id) }}">Change Trip</a>
</div>

<div class="field-row">
    <div class="field">
        <div class="field__label">Traveler</div>
        <div class="field__value">{{ $project->trip->traveler }}</div>
    </div>
    <div class="field">
        <div class="field__label">Destination</div>
        <div class="field__value">{{ $project->trip->destination }} 
       <select class="form-control">
           @foreach($states as $state)
               <option value="{{$state->name}}">{{$state->name}}</option>
           @endforeach
       </select>
    </div>
    
    </div>
    <div class="field">
        <div class="field__label">Dates</div>
        <div class="field__value">{{ eDate($project->trip->depart_at) }} &ndash; {{ eDate($project->trip->return_at) }}</div>
    </div>
    <div class="field">
        <div class="field__label">Times</div>
        <div class="field__value">{{ eTime($project->trip->depart_at_time) }} &ndash; {{ eTime($project->trip->return_at_time) }}</div>
    </div>
</div>

<div class="project-flags">
    @if($project->trip->non_uw)
        <span>@icon('user-tag') Non-UW Traveler</span>
        <div class="field__value">
            Mailing address:<br />
            {{ $project->trip->nuwt_address_line1 }} <br />
            {{ $project->trip->nuwt_address_line2 }} <br />
            {{ $project->trip->nuwt_city }}, {{ $project->trip->nuwt_state_province }}, {{ $project->trip->nuwt_zipcode }} <br />
            {{ $project->trip->nuwt_country }}
       </div>
    @endif
    @if($project->trip->non_uw)
        <span>@icon('island-tropical') Using Personal Time</span>
    @endif
    @if($project->trip->honorarium)
        <span>@icon('money-check-edit') {{ $project->trip->honorarium }} Honorarium</span>
    @endif
</div>
