<?php

if (isset($order)) {
    $closeAction = route('close-order', $order->id);
} else {
    $closeAction = route('close-project', $project->id);
}

?>

<a class="btn" href="{{ route('project', [$project->id, 'add']) . '#_menu_' }}">
    @icon('plus') Order
</a>

@if($project->closed_at)

    <button class="btn js-toggle-target" data-target="project-close-dialog">
        @icon('box') Project Closed
        <span class="text-muted ml-2">
            by {{ eFirstLast($project->closed_by) }} {{ eDate($project->closed_at) }}
        </span>
    </button>

    <div id="project-close-dialog" style="display: none;">
        This project is currently closed, indicating all orders are resolved and no further activity
        is expected. Closed projects do not show up in lists on the home page. If a new order is added
        to this project it will automatically re-open.
    </div>

@elseif($project->canClose())

    <button class="btn js-toggle-target" data-target="project-close-dialog">
        @icon('box') Close Project
    </button>

    <div id="project-close-dialog" style="display: none;">
        This project may be closed, indicating all orders are resolved and no further activity
        is expected. Closing a project keeps it from showing up in lists on the home page.
        <div class="my-3">
            <form action="{{ $closeAction }}" method="post">
                {!! csrf_field() !!}
                <button type="submit" class="btn btn-primary">Close Project</button>
            </form>
        </div>
    </div>

@else

    <button class="btn js-toggle-target" data-target="project-close-dialog">
        @icon('box-open') Project is Open
    </button>

    <div id="project-close-dialog" style="display: none;">
        This project is open. It has one or more orders that are active so it may not be closed
        at this time. To close a project <strong>Complete</strong> or <strong>Cancel</strong>
        all orders.
    </div>

@endif
