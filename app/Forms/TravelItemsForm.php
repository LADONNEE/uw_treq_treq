<?php
namespace App\Forms;

use App\Models\Order;
use App\Api\ItemsApi;

class TravelItemsForm extends Form
{
    private $order;
    public $items;

    public function __construct(Order $order)
    {
        $this->order = $order;

        $this->items = new ItemsApi($order, [
            'Airfare',
            'Meals',
            'Lodging',
            'Registration',
            'Car Service',
            'Car Rental',
            'Mileage',
        ]);
    }

    public function createInputs()
    {
        $this->add('items_json');
    }

    public function initValues()
    {
        $this->input('items_json')->value($this->items->toString());
    }

    public function validate()
    {
        // no server side validation needed
    }

    public function commit()
    {
        $this->items->save($this->value('items_json'));
    }
}
