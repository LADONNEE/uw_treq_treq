<div class="text-right text-sm-bold">
    <a href="{{ route('project-edit', $order->id) }}">Change Project</a>
</div>

<div class="field-row">
    <div class="field">
        <div class="field__label">Project Owner</div>
        <div class="field__value">{{ eFirstLast($project->person_id) }}</div>
    </div>
</div>

<div class="project-flags">
    @if($project->is_food)
        <span>@icon('cookie-bite') Food purchase</span>
    @endif
    @if($project->is_gift_card)
        <span>@icon('credit-card') Gift Card purchase</span>
    @endif
</div>
