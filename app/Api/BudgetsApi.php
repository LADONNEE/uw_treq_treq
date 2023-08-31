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
                'name' => $budget->name,
                'wd_costcenter' => $budget->wd_costcenter,
                'wd_program' => $budget->wd_program,
                'wd_standalonegrant' => $budget->wd_standalonegrant,
                'wd_grant' => $budget->wd_grant,
                'wd_assignee' => $budget->wd_assignee,
                'wd_gift' => $budget->wd_gift,
                'wd_fund' => $budget->wd_fund,
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
