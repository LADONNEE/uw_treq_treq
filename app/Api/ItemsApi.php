<?php
namespace App\Api;

use App\Models\Order;

class ItemsApi
{
    private $order;
    private $defaultItems;

    public function __construct(Order $order, $defaultItems = [])
    {
        $this->order = $order;
        $this->defaultItems = $defaultItems;
    }

    public function save($itemsJson)
    {
        $items = json_decode($itemsJson, true);

        foreach ($items as $data) {
            $i = new ItemsApiItem($this->order->id, $data);
            $i->save();
        }
    }

    public function toArray()
    {
        $out = [];
        foreach ($this->order->items as $item) {
            $out[] = [
                'id' => $item->id,
                'name' => $item->name,
                'url' => $item->url,
                'qty' => $this->safeQty($item->qty),
                'amount' => $this->safeAmount($item->amount),
                'action' => 'none',
            ];
        }

        foreach ($this->defaultItems as $name) {
            if (!$this->hasItemName($out, $name)) {
                $out[] = $this->itemDefaults($name);
            }
        }

        return $out;
    }

    public function toString()
    {
        return json_encode($this->toArray());
    }

    private function hasItemName($list, $name)
    {
        foreach ($list as $item) {
            if ($item['name'] === $name) {
                return true;
            }
        }
        return false;
    }

    private function itemDefaults($name)
    {
        return [
            'id' => null,
            'name' => $name,
            'url' => null,
            'qty' => 1,
            'amount' => null,
            'action' => 'default',
        ];
    }

    /**
     * Force $input to integer, change 0 or non-number values to 1
     */
    private function safeQty($input): int
    {
        $out = (int) $input;
        return ($out) ?: 1;
    }

    /**
     * Force $input to float with 2 places, change empty or non-number to null
     */
    private function safeAmount($input): ?float
    {
        if ($input === null || $input === '' || !is_numeric($input)) {
            return null;
        }

        return round($input, 2);
    }
}
