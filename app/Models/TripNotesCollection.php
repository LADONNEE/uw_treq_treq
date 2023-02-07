<?php

namespace App\Models;

class TripNotesCollection
{
    /**
     * @var TripNotesResponse[]
     */
    public $notes = [];

    private $config = [
        'personal_time' => [
            'question' => 'Did any part of this request include personal time?',
            'label' => 'Personal Time',
            'precision' => 'Please pro-rate Per Diem, Lodging, car rental & Long term Parking reimbursement (as applicable).'
        ],
        'airfare_needed' => [
            'question' => 'Is Comparision airfare needed for this reimbursment (If personal time is included with business travel)?',
            'label' => 'Airfare',
            'precision' => 'Please upload a copy of comparison airfare if required.'
        ],
        'travel_reimbursed' => [
            'question' => 'Was any part of this travel reimbursement previously reimbursed?',
            'label' => 'Reimbursed',
            'precision' => 'Please provide details including description & amounts when applicable.'
        ],
        'travel_sponsored' => [
            'question' => 'Was any part of this travel sponsored or paid for by another entity (Conference registration, hotel, flight, 
            etc.)?',
            'label' => 'Sponsored',
            'precision' => 'Please provide details including description & amounts when applicable.'
        ],
        'flights_upgrades' => [
            'question' => 'Were there any flight upgrades?',
            'label' => 'Upgraded Flight',
            'precision' => 'Please provide details including description & amounts when applicable.'
        ],
        'lodging_over' => [
            'question' => 'Did you pay more than maximum allowable lodging rate?',
            'label' => 'Over Lodging Per Diem',
            'precision' => 'Please indicate amount and explain reason(s)',
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
            'precision' => 'Please provide details of name(s) of traveler, description and amounts paid.'
        ],
        'meals_provided' => [
            'question' => 'Were any meals provided? (List dates and meals provided.)',
            'label' => 'Please list Meals and dates',
            'precision' => 'Please provide details including description & amounts when applicable.'
        ],
        'travel_changed' => [
            'question' => 'Did your travel plans change during trip (flight delays, came home early, etc.)?',
            'label' => 'Plans Changed',
            'precision' => 'Please provide details including description & amounts when applicable.'
        ],
        'other_funding' => [
            'question' => 'Do you have other funding (not previously included on Pre-Travel Authorization)?',
            'label' => 'Other Funding',
            'precision' => 'Please provide details including description & amounts when applicable.'
        ],
        'driving' => [
            'question' => ' Is this reimbursement for "driving" travel time?',
            'label' => 'Driving',
            'precision' => 'If Yes, please include time left (start of driving time) & time arrived at starting point (time arrived at home)'
        ],
        'reimbursed_amount' => [
            'question' => 'Does any reimbursed amount differ from receipts enclosed in this reimbursement?',
            'label' => 'Reimbursed Amount',
            'precision' => 'If yes, please provide details and reason(s) for the difference.'
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
                $c['options'] ?? null,
                $c['precision'] ?? null
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
