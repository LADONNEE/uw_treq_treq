<?php
namespace App\Api;

use App\Models\Order;

class BudgetsApi
{
    private $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function save($itemsJson)
    {
        $items = json_decode($itemsJson, true);

        foreach ($items as $data) {
            $i = new BudgetsApiItem($this->order->id, $data);
            $i->save();
        }
    }

    public function toArray()
    {
        $out = [];
        foreach ($this->order->budgets as $budget) {
            $out[] = [
                'id' => $budget->id,
                'budgetno' => $budget->budgetno,
                'pca_code' => $budget->pca_code,
                'project_code_id' => $budget->project_code_id,
                'opt_code' => $budget->opt_code,
                'name' => $budget->name,
                'split_type' => $budget->split_type,
                'split' => $budget->split,
                'action' => 'none',
            ];
        }
        return $out;
    }

    public function toString()
    {
        return json_encode($this->toArray());
    }
}
