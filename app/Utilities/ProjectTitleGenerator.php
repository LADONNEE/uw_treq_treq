<?php
namespace App\Utilities;

use App\Models\Order;
use App\Models\Trip;

class ProjectTitleGenerator
{
    public function title(Order $order, Trip $trip = null): string
    {
        if ($trip || $order->isTravel()) {
            return $this->travelTitle($order, $trip);
        }
        return $this->projectTitle($order);
    }

    private function projectTitle(Order $order): string
    {
        return $this->prefix($order->type). ': ' . $order->submitter->lastname;
    }

    private function travelTitle(Order $order, ?Trip $trip): string
    {
        if ($trip) {
            return 'Travel: ' . $trip->traveler . ' > ' . $trip->destination;
        }
        return 'Travel: ' . eFirstLast($order->submitted_by);
    }

    private function prefix($type) {
        switch ($type) {
            case 'travel-pre-auth':
            case 'travel-reimbursement':
                return 'Travel';
            case 'pre-auth':
                return 'Pre-Auth';
            case 'purchase':
                return 'Purchase';
            case 'reimbursement':
                return 'Reimbursement';
            case 'invoice':
                return 'Invoice';
            default:
                return 'Project';
        }
    }
}

