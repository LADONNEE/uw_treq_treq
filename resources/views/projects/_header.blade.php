@if($project->is_travel)
    @include('trips._header')
@else

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
                    @bar {{ eFirstLast($project->person_id) }}
                </div>
            @endif
        </div>

        <div class="project-flags">
            @if($project->is_food)
                <div>@icon('cookie-bite') Food purchase</div>
            @endif
            @if($project->is_gift_card)
                <span>@icon('credit-card') Gift Card purchase</span>
            @endif
        </div>
    </section>

@endif
