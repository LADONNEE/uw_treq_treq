<?php
namespace App\Workflows\Templates;

class TemplateFactory
{
    private $workflows = [
        'travel-pre-auth' => TravelPreAuth::class,
        'travel-reimbursement' => TravelReimbursement::class,
        'pre-auth' => PreAuth::class,
        'purchase' => Purchase::class,
        'reimbursement' => Reimbursement::class,
        'invoice' => Invoice::class,
    ];

    public function get($type): Template
    {
        if ($type && isset($this->workflows[$type])) {
            $classname = $this->workflows[$type];
        } else {
            $classname = SimpleOrder::class;
        }
        return new $classname();
    }
}
