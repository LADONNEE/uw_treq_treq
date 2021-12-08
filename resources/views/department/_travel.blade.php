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
        <div class="field__value">{{ $project->trip->destination }}</div>
    </div>
    <div class="field">
        <div class="field__label">Dates</div>
        <div class="field__value">{{ eDate($project->trip->depart_at) }} &ndash; {{ eDate($project->trip->return_at) }}</div>
    </div>
</div>

<div class="project-flags">
    @if($project->trip->non_uw)
        <span>@icon('user-tag') Non-UW Traveler</span>
    @endif
    @if($project->trip->non_uw)
        <span>@icon('island-tropical') Using Personal Time</span>
    @endif
    @if($project->trip->honorarium)
        <span>@icon('money-check-edit') {{ $project->trip->honorarium }} Honorarium</span>
    @endif
</div>
