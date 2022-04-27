<template>
    <div class="col my-3 mx-auto mw-600">
        <dl>
            <dt>Budget Number</dt>
            <dd>
                Enter the six digit UW budget number. This field will suggest UAA budgets.
            </dd>

            <dt class="mt-4">Name</dt>
            <dd>
                Name or description of the budget. If you choose a suggestion in the Budget
                Number field, this is filled in for you.
            </dd>

            <dt class="mt-4">PCA Code</dt>
            <dd>
                (Optional) AKA Project code or TOP code. If you know it fill it in. If you
                are not sure, leave it blank and your budget's fiscal manager will add the
                correct coding.
            </dd>

            <dt class="mt-4">Split for Single Budget</dt>
            <dd>
                Leave Split blank (or 100). One budget with Split Type "* Remainder" means
                everything gets charged to this budget.
            </dd>

            <dt class="mt-4">Split for Multiple Budgets</dt>
            <dd>
                Split Type "$ Dollar Amount" will charge a fixed dollar amount to a budget.
                $ Dollar Amount splits are applied first.<br>
                <br>
                Split Type "% Percentage" charges the percentage of the remaining total
                (after $ Dollar Amounts) to the budget. These are charged second.<br>
                <br>
                Any remaining amount is charged to the "* Remainder" budget. Always add
                exactly one * Remainder budget.
            </dd>
        </dl>
    </div>
</template>
