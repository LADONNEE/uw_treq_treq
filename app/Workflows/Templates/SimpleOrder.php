<?php
namespace App\Workflows\Templates;

use App\Workflows\TaskSteps\BudgetApproval;
use App\Workflows\TaskSteps\DepartmentApproval;
use App\Workflows\TaskSteps\FiscalContact;

class SimpleOrder extends Template
{
    public function requestSteps(): array
    {
        return [
            'project',
            'items',
            'attachments',
            'budgets',
            'department',
        ];
    }

    public function taskSteps(): array
    {
        return [
            DepartmentApproval::class,
            FiscalContact::class,
            BudgetApproval::class,
        ];
    }
}
