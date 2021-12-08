<?php
namespace App\Api;

use App\Models\Item;

class ItemsApiItem
{
    private $order_id;
    private $data;
    private $id;
    private $name;
    private $action;

    public function __construct($order_id, $data)
    {
        $this->order_id = $order_id;
        $this->data = $data;
        $this->id = $data['id'] ?? null;
        $this->name = $data['name'] ?? null;
        $this->action = $data['action'] ?? 'save';
        unset($this->data['action']);
        unset($this->data['key']);
    }

    public function save()
    {
        if ($this->isEmptyDefaultItem()) {
            return;
        }

        if ($this->action === 'delete' || !$this->name) {
            $this->delete();
            return;
        }

        if ($this->id) {
            $this->update();
        } else {
            $this->insert();
        }
    }

    private function isEmptyDefaultItem()
    {
        return !$this->id && $this->action === 'default' && !$this->data['amount'];
    }

    private function insert()
    {
        $item = new Item(['order_id' => $this->order_id]);
        $item->fill($this->data);
        $item->save();
    }

    private function update()
    {
        $item = Item::query()->find($this->id);
        if ($item instanceof Item) {
            $item->fill($this->data);
            $item->save();
        }
    }

    private function delete()
    {
        if (!$this->id) {
            return;
        }
        Item::where('id', $this->id)->delete();
    }
}
