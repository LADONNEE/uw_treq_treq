@if($canEdit)
    <div class="text-right text-sm-bold m-2">
        <a href="{{ route('budgets', $order->id) }}">Change Budgets</a>
    </div>
@endif
<section class="mb-4 border rounded">
    @foreach($order->budgets as $budget)

        <div class="budget-block">
            <div class="budget-block__wd_costcenter">{{ $budget->wd_costcenter }}</div>
        
            @if( $budget->budgetno != '00-0000')
            <div class="budget-block__budgetno">{{ $budget->budgetno }}</div>
            <div class="budget-block__name">{{ $budget->name }}</div>
            @endif

            <div class="budget-block__worktags">
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
            </div>

            <div class="budget-block__pca">{{ $budget->pca_code }}</div>
            <div class="budget-block__opt">OPT: {{ $budget->opt_code ?? 'no opt' }}</div>
            <div class="budget-block__split">{{ $budget->splitDescription() }}</div>
        </div>

    @endforeach
</section>
