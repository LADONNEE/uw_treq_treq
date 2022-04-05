<?php
    $trip = $project->trip ?? new \App\Models\Trip();
?>
<section class="project-header">
    <div class="mb-3">
        <h1>@projectNumber($project) {{ $project->title }}</h1>

        @if(isset($order))
            <div class="project-header__ordert text-med text-gray">
                {{ $order->typeName() }}
                @if($order->submitted_at)
                    @bar
                    Submitted {{ eDate($order->submitted_at) }}
                    by {{ eFirstLast($order->submitter) }}
                @else
                    @bar {{ $order->stage }}
                @endif
            </div>
        @endif
    </div>

    <div class="fields-inline">
        <div class="field">
            <div class="field__label">Traveler</div>
            <div class="field__value">{{ $trip->traveler ?? '(missing)' }}</div>
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
           <div class="field__label">Times</div>
           <div class="field__value">{{ eTime($trip->depart_at_time) }} &ndash; {{ eTime($trip->return_at_time) }}</div>
       </div>
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
</section>
