<?php
namespace App\Api;

use App\Models\Order;

class OrderApi
{
    private $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function toArray()
    {
        $out = $this->order->toArray();
        $out['typeName'] = $this->order->typeName();
        $out['submittedName'] = eFirstLast($this->order->submitted_by);
        $out['urlTasks'] = route('tasks-api', $this->order->id);
        $out['urlNotes'] = '';
        $out['items'] = (new ItemsApi($this->order))->toArray();
        $out['budgets'] = (new BudgetsApi($this->order))->toArray();
        $out['otherOrders'] = $this->otherOrders();
        return $out;
    }

    private function otherOrders()
    {
        $orders = Order::where('project_id', $this->order->project_id)
            ->where('id', '<>', $this->order->id)
            ->whereNotNull('submitted_at')
            ->orderBy('submitted_at')
            ->get();

        $out = [];
        foreach ($orders as $order) {
            $out[] = (new OrderApiBrief($order))->toArray();
        }
        return $out;
    }
}
