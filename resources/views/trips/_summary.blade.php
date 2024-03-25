<?php
$trip = $project->trip ?? new \App\Models\Trip();
?>
<section>
    @if(isset($order) && $canEdit->project)
        <div class="float-right text-sm-bold">
            <a href="{{ route('project-edit', $order->id) }}/trip">Change Trip</a>
        </div>
    @endif

    <div class="field">
        <div class="field__label">Traveler</div>
        <div class="field__value">{{ $trip->traveler ?? '(missing)' }}</div>
        @if($trip->traveler_email)
            <div class="field__value mt-2">{{ $trip->traveler_email }}</div>
        @endif
        @if($trip->traveler_phone)
            <div class="field__value">{{ $trip->traveler_phone }}</div>
        @endif
    </div>
    <div class="field">
        <div class="field__label">Destination</div>
        <div class="field__value">{{ $trip->destination ?? '(missing)' }}</div>
        <div class="field__value">{{ $trip->state ?? '(missing)' }}</div>
    </div>
    <div class="field">
        <div class="field__label">Dates</div>
        <div class="field__value">{{ eDate($trip->depart_at) }} &ndash; {{ eDate($trip->return_at) }}</div>
    </div>
    <div class="field">
        <div class="field__label">Times</div>
        <div class="field__value">{{ eTime($trip->depart_at_time) }} &ndash; {{ eTime($trip->return_at_time) }}</div>
   </div>

    <div class="field">
        <div class="field__label">Requestor</div>
        <div class="field__value">{{ eFirstLast($project->person_id) }}</div>
    </div>

    <div class="project-flags">
        @if($trip->non_uw)
            <div>@icon('user-tag') Non-UW Traveler</div>
            <div class="field__value">
               Mailing address:<br />
               {{ $trip->nuwt_address_line1 }} <br />
               {{ $trip->nuwt_address_line2 }} <br />
               {{ $trip->nuwt_city }}, {{ $trip->nuwt_state_province }}, {{ $trip->nuwt_zipcode }} <br />
               {{ $trip->nuwt_country }}           
            
        </div>
        @endif
        @if($trip->personal_time)
            <div>@icon('island-tropical') Using Personal Time</div>
        @endif
        @if($trip->honorarium)
            <div>@icon('money-check-edit') {{ $trip->honorarium }} Honorarium</div>
        @endif
    </div>

    <div class="field">
        <div class="field__label">Description and Business Purpose</div>
        <div class="field__value">{{ $project->purpose }}</div>
    </div>
    <div class="field">
        <div class="field__label">Description and Business Relevance</div>
        <div class="field__value">{{ $project->relevance }}</div>
    </div>
    <div class="field">
        <div class="field__label">Description and Business Arrangement</div>
        <div class="field__value">{{ $project->arrangement }}</div>
    </div>
</section>
