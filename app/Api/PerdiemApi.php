<?php

namespace App\Api;

use App\Models\Order;
use App\Models\Perdiem;
use Carbon\Carbon;

class PerdiemApi
{
    private $order;
    private $properties = [
        'nights' => 'int',
        'lodging_pd' => 'int',
        'lodging' => 'decimal',
        'days' => 'int',
        'meals_pd' => 'int',
        'meals' => 'int',
    ];

    public $perdiem;

    public function __construct(Order $order)
    {
        $this->order = $order;
        $this->perdiem = $order->perdiem ?? new Perdiem(['order_id' => $order->id]);
    }

    public function formState()
    {
        $out = [];

        foreach ($this->properties as $property => $t) {
            $out[$property] = $this->perdiem->{$property};
        }

        if (!$this->perdiem->exists) {
            $out['nights'] = $this->tripNights();
            $out['days'] = $out['nights'] + 1;
        }

        return $out;
    }

    private function tripNights()
    {
        if ($this->order->project && $this->order->project->trip) {
            $trip = $this->order->project->trip;
            if ($trip->depart_at instanceof Carbon && $trip->return_at instanceof Carbon) {
                return $trip->return_at->diffInDays($trip->depart_at);
            }
        }
        return 0;
    }

    public function patch($input)
    {
        if (!is_array($input)) {
            $input = json_decode($input, true);
        }

        $out = [];

        foreach ($this->properties as $property => $t) {
            if (array_key_exists($property, $input)) {
                $out[$property] = ($t === 'decimal') ? $this->toDecimal($input[$property]) : $this->toInteger($input[$property]);
            }
        }

        return $out;
    }

    private function toInteger($value)
    {
        if ($value === null || $value === '') {
            return null;
        }
        return (int) preg_replace('/[^0-9\.]/', '', $value);
    }

    private function toDecimal($value)
    {
        if ($value === null || $value === '') {
            return null;
        }
        $value = (float) preg_replace('/[^0-9\.]/', '', $value);
        return number_format($value, 2, '.', '');
    }
}
