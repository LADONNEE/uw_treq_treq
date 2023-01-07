@if($canEdit)
    <div class="text-right text-sm-bold m-2">
        <a href="{{ route('budgets', $order->id) }}">Change Budgets</a>
    </div>
@endif
<section class="mb-4 border rounded">
    @foreach($order->budgets as $budget)

        <div class="budget-block">
            <div class="budget-block__budgetno">{{ $budget->budgetno }}</div>
            <div class="budget-block__name">{{ $budget->name }}</div>
            <div class="budget-block__pca">{{ $budget->pca_code }}</div>
            <div class="budget-block__opt">OPT: {{ $budget->opt_code ?? 'no opt' }}</div>
            <div class="budget-block__split">{{ $budget->splitDescription() }}</div>
        </div>

    @endforeach
</section>
