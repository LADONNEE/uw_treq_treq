<?php
namespace App\Api;

use App\Models\Budget;

class BudgetsApiItem
{
    private $order_id;
    private $data;
    private $id;
    private $budgetno;
    private $action;

    public function __construct($order_id, $data)
    {
        $this->order_id = $order_id;
        $this->data = $data;
        $this->id = $data['id'] ?? null;
        $this->budgetno = $data['budgetno'] ?? null;
        $this->action = $data['action'] ?? 'save';
        $this->data['split'] = $this->scrubFloat($data['split'] ?? null);
        unset($this->data['action']);
        unset($this->data['key']);
    }

    public function save()
    {
        if ($this->action === 'delete' || !$this->budgetno) {
            $this->delete();
            return;
        }

        $this->applyDefaults();

        if ($this->id) {
            $this->update();
        } else {
            $this->insert();
        }
    }

    private function scrubFloat($input)
    {
        if (!$input) {
            return null;
        }
        $input = preg_replace('/[^0-9\.]/', '', $input);
        return (float) $input;
    }

    private function applyDefaults()
    {
        if (!isset($this->data['name']) || !$this->data['name']) {
            $this->data['name'] = trim("{$this->budgetno} Budget");
        }
        if (!isset($this->data['split_type']) || !$this->data['split_type']) {
            $this->data['split_type'] = 'R';
        }
        if (!isset($this->data['split']) || !$this->data['split']) {
            $this->data['split'] = 100;
        }
    }

    private function insert()
    {
        $item = new Budget(['order_id' => $this->order_id]);
        $item->fill($this->data);
        $item->save();
    }

    private function update()
    {
        if (!$this->id) {
            return;
        }
        Budget::where('id', $this->id)->update($this->data);
    }

    private function delete()
    {
        if (!$this->id) {
            return;
        }
        Budget::where('id', $this->id)->delete();
    }
}
