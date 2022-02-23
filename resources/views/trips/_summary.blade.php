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
    </div>
    <div class="field">
        <div class="field__label">Dates</div>
        <div class="field__value">{{ eDate($trip->depart_at) }} &ndash; {{ eDate($trip->return_at) }}</div>
    </div>

    <div class="field">
        <div class="field__label">Project Owner</div>
        <div class="field__value">{{ eFirstLast($project->person_id) }}</div>
    </div>

    <div class="project-flags">
        @if($trip->non_uw)
            <div>@icon('user-tag') Non-UW Traveler</div>
        @endif
        @if($trip->non_uw)
            <div>@icon('island-tropical') Using Personal Time</div>
        @endif
        @if($trip->honorarium)
            <div>@icon('money-check-edit') {{ $trip->honorarium }} Honorarium</div>
        @endif
    </div>

    <div class="field">
        <div class="field__label">Business Purpose</div>
        <div class="field__value">{{ $project->purpose }}</div>
    </div>
</section>