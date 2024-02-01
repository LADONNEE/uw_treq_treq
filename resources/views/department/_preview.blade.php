<?php
$project = $project ?? $order->project;
?>
<h1 class="mb-3">{{ $project->title }}</h1>


@if($project->is_travel)
    @include('department._travel')
@else
    @include('department._project')
@endif

<div class="field">
    <div class="field__label">Description and Business Purpose</div>
    <div class="field__value mw-500">{{ $project->purpose }}</div>
</div>

@if($project->is_travel)
<div class="field">
    <div class="field__label">Description and Business Relevance</div>
    <div class="field__value mw-500">{{ $project->relevance }}</div>
</div>

<div class="field">
    <div class="field__label">Description and Business Arrangement</div>
    <div class="field__value mw-500">{{ $project->arrangement }}</div>
</div>
@endif

<section class="mb-4">
    <h2 class="mb-2">Items</h2>

    @if($order->items)

        <div class="float-right text-sm-bold">
            <a href="{{ route('items', $order->id) . $order->tripUrlSegment() }}">Change Items</a>
        </div>

        @include('orders._items', ['canEdit' => false])

    @else

        <p><a href="{{ route('items', $order->id) }}">&plus; Items</a></p>

    @endif
    @include('notes._section-ro', ['notes' => $order->sectionNotes('items')])
</section>

<section class="mb-4">
    <h2 class="mb-2">Budgets</h2>

    @if($order->budgets)

        <div class="float-right text-sm-bold">
            <a href="{{ route('budgets', $order->id) }}">Change Budgets</a>
        </div>
        <table class="table-tight">
            <thead>
            <tr>
                <th>Cost Center</th>
                <th>(Budget)</th>
                <th>Worktags</th>
                <th class="text-right">Split</th>
            </tr>
            </thead>
            <tbody>

            @foreach($order->budgets as $budget)
                
                <tr >
                    <td class="worktag-tag">
                        <span>{{ $budget->wd_costcenter }}</span>
                    </td>
                    <td>
                        @if( $budget->budgetno != '00-0000')
                            <span>{{ $budget->budgetno }}</span>
                        @endif
                    </td>
                    <td class="worktag-tag">
                        @if( $budget->wd_program)
                        <span>{{ $budget->wd_program }}</span>
                        @endif
                        @if( $budget->wd_standalonegrant)
                            <span>{{ $budget->wd_standalonegrant }}</span>
                        @endif
                        @if( $budget->wd_grant)
                            <span>{{ $budget->wd_grant }}</span>
                        @endif
                        @if( $budget->wd_gift)
                            <span>{{ $budget->wd_gift }}</span>
                        @endif
                        @if( $budget->wd_fund)
                            <span>{{ $budget->wd_fund }}</span>
                        @endif
                    </td>
                    
                    <td class="text-right">{{ $budget->splitDescription() }}</td>
                </tr>

            @endforeach

            </tbody>
        </table>

    @else

        <p><a href="{{ route('budgets', $order->id) }}">&plus; Budgets</a></p>

    @endif
    @include('notes._section-ro', ['notes' => $order->sectionNotes('budget')])
</section>
