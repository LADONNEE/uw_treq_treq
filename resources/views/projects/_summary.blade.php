<section>
    @if(isset($order) && $canEdit->project)
        <div class="float-right text-sm-bold">
            <a href="{{ route('project-edit', $order->id) }}">Change Project</a>
        </div>
    @endif

    <div class="field">
        <div class="field__label">Requestor</div>
        <div class="field__value">{{ eFirstLast($project->person_id) }}</div>
    </div>

    <div class="project-flags">
        @if($project->is_food)
            <div>@icon('cookie-bite') Food purchase</div>
        @endif
        @if($project->is_gift_card)
            <span>@icon('credit-card') Gift Card purchase</span>
        @endif
        @if($project->is_rsp)
            <span>@icon('microscope') Research Subject Payments</span>
        @endif
    </div>

    <div class="field">
        <div class="field__label">Description and Business Purpose</div>
        <div class="field__value">{{ $project->purpose }}</div>
    </div>
</section>
