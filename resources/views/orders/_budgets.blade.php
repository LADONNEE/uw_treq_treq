@if($canEdit)
    <div class="text-right text-sm-bold m-2">
        <a href="{{ route('budgets', $order->id) }}">Change Budgets</a>
    </div>
@endif
<section class="mb-4 border rounded">
    @foreach($order->budgets as $budget)

        <div class="budget-block">
            <div class="budget-block__wd_costcenter">
                @if( $budget->wd_program)
                    {{ \App\Models\WorktagLookup::where('workday_code', $budget->wd_costcenter)->first()->name}}
                @endif
            </div>
        
            @if( $budget->budgetno != '00-0000')
            <div class="budget-block__budgetno">{{ $budget->budgetno }}</div>
            <div class="budget-block__name">{{ $budget->name }}</div>
            @endif

            <div class="budget-block__worktags worktag-tag">
                @if( $budget->wd_program)
                    <div class="wdpg">{{ \App\Models\WorktagLookup::where('workday_code', $budget->wd_program)->first()->name }}</div>
                @endif
                @if( $budget->wd_grant)
                    <div class="wdgr">{{ \App\Models\WorktagLookup::where('workday_code', $budget->wd_grant)->first()->name }}</div>
                @endif
                @if( $budget->wd_gift)
                    <div class="wdgf">{{ \App\Models\WorktagLookup::where('workday_code', $budget->wd_gift)->first()->name }}</div>
                @endif
                @if( $budget->wd_fund)
                    <div class="wdfd">{{ \App\Models\WorktagLookup::where('workday_code', $budget->wd_fund)->first()->name }}</div>
                @endif
            </div>

            <div class="budget-block__pca">{{ $budget->pca_code }}</div>
            <div class="budget-block__split">{{ $budget->splitDescription() }}</div>
        </div>

    @endforeach
</section>
