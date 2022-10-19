<?php
namespace App\Workflows;

class OrderTypes
{
    const TRAVEL_REIMBURSEMENT = 'travel-reimbursement';

    public $types = [];

    public function __construct()
    {
        $this->types = [
            new OrderType('travel-pre-auth', 'Travel Pre-Authorization', 'plane-departure'),
            new OrderType(self::TRAVEL_REIMBURSEMENT, 'Travel Reimbursement', 'plane-arrival'),
            new OrderType('pre-auth', 'Other Pre-Authorization', 'ballot-check'),
            new OrderType('reimbursement', 'Non-Travel Reimbursement', 'receipt'),
            new OrderType('purchase', 'Make a Purchase', 'box-alt'),
            new OrderType('invoice', 'Pay an Invoice', 'file-invoice'),
        ];
    }

    public function typesThreeByTwo()
    {
        return [
            $this->types[0],
            $this->types[1],
            $this->types[2],
            $this->types[3],
            $this->types[4],
            $this->types[5],
        ];
    }
}
