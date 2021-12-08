<?php

namespace App\Reports;

use App\Models\Order;

/**
 * Orders where given person is the Order Submitter or the Project owner
 */
class MyOrdersReport
{
    public $title = 'My Orders';
    public $view = 'orders._status-table';
    public $viewCsv = 'orders.csv';

    public $count = 0;
    public $orders;
    public $days;

    protected $person_id;

    public function __construct($person_id, $days = 90)
    {
        $this->person_id = $person_id;
        $this->days = $days;
        $this->orders = $this->load();
        $this->count = count($this->orders);
    }

    public function load()
    {
        $person_id = $this->person_id;
        $days = ($this->days) ?: 90;

        return Order::select('orders.*')
            ->join('projects', 'projects.id', '=', 'orders.project_id')
            ->where(function($query) use($person_id){
                $query->where('orders.submitted_by', $person_id)
                    ->orWhere('projects.person_id', $person_id);
            })
            ->whereNotNull('orders.submitted_at')
            ->where(function($query) use($days) {
                $query->whereNotIn('orders.stage', [Order::STAGE_COMPLETE, Order::STAGE_CANCELED])
                    ->orWhere('orders.updated_at', '>', now()->subDays($days));
            })
            ->orderBy('orders.created_at', 'desc')
            ->with(['project', 'submitter', 'tracking'])
            ->get();
    }
}
