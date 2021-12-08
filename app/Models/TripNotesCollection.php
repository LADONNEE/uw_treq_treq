<?php

namespace App\Models;

class TripNotesCollection
{
    /**
     * @var TripNotesResponse[]
     */
    public $notes = [];

    private $config = [
        'lodging_over' => [
            'question' => 'Did you pay more than maximum allowable lodging rate?',
            'label' => 'Over Lodging Per Diem',
            'options' => [
                'Conference Hotel',
                'Special Event or Disaster',
                'ADA or Safety/Health',
                'Suite Required',
                'Lower Cost Overall',
            ],
        ],
        'paid_for_other' => [
            'question' => 'Did you pay for any expenses for another traveler (lodging, airfare, registration, etc)?',
            'label' => 'Other Traveler',
        ],
        'meals_provided' => [
            'question' => 'Were any meals provided?',
            'label' => 'Meals Provided',
        ],
        'travel_changed' => [
            'question' => 'Did your travel plans change during trip (flight delays, came home early, etc.)?',
            'label' => 'Plans Changed',
        ],
        'other_funding' => [
            'question' => 'Do you have other funding (not previously included on Pre-Travel Authorization)?',
            'label' => 'Other Funding',
        ],
    ];

    private $order_id;

    public function __construct($order_id)
    {
        $this->order_id = $order_id;
        foreach ($this->config as $item => $c) {
            $this->notes[$item] = new TripNotesResponse(
                $order_id,
                $item,
                $c['label'],
                $c['question'],
                $c['options'] ?? null
            );
        }
        $notes = TripNote::where('order_id', $this->order_id)->get();
        foreach ($notes as $tn) {
            if (isset($this->notes[$tn->item])) {
                $this->notes[$tn->item]->load($tn);
            }
        }
    }
}
