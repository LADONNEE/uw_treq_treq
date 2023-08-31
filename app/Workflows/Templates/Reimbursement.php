<?php
namespace App\Workflows\Templates;

use App\Workflows\TaskSteps\CostcenterApproval;
use App\Workflows\TaskSteps\DepartmentApproval;
use App\Workflows\TaskSteps\EnterInAriba;
use App\Workflows\TaskSteps\FiscalContact;

class Reimbursement extends Template
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
            CostcenterApproval::class,
            EnterInAriba::class,
        ];
    }
}
