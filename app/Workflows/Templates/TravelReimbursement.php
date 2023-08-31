<?php
namespace App\Workflows\Templates;

use App\Workflows\TaskSteps\CostcenterApproval;
use App\Workflows\TaskSteps\DepartmentApproval;
use App\Workflows\TaskSteps\EnterInAriba;
use App\Workflows\TaskSteps\FiscalContact;

class TravelReimbursement extends Template
{
    public function requestSteps(): array
    {
        return [
            'trip',
            'trip-items',
            'trip-notes',
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
