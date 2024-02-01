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
            'precision' => 'Please include dates, location and times. Please pro-rate Per Diem, Lodging, car rental & Long term Parking reimbursement (as applicable).'
        ],
        'airfare_needed' => [
            'question' => 'Is Comparision airfare needed for this reimbursment (If personal time is included with business travel)?',
            'label' => 'Airfare',
            'precision' => 'Please upload a copy of comparison airfare if required.'
        ],
        'flights_upgrades' => [
            'question' => 'Were there any flight upgrades? (Pre-Approval Required)',
            'label' => 'Upgraded Flight',
            'precision' => 'Pre-Approval should be in TREQ. Please provide details including description & amounts when applicable.'
        ],
        'travel_conference' => [
            'question' => 'Is this travel for a conference?',
            'label' => 'Conference',
            'precision' => 'Please look up conference dates (include a copy of the conference dates to Finance) to verify that travel dates comply with UW Policy'
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
        'lodging_over' => [
            'question' => 'Did you pay more than maximum allowable lodging rate?',
            'label' => 'Over Lodging Per Diem',
            'precision' => 'Please indicate amount and explain reason(s). Include a map if the hotel is more than 5 miles from the conference.',
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
            'precision' => 'Please provide details of name(s) of traveler, description and amounts paid, including receipts'
        ],
        'meals_provided' => [
            'question' => 'For reimbursement of per diem, please confirm if  any meals were included?',
            'label' => 'Please list Meals and dates',
            'precision' => 'Please provide details of meals provided, including amounts and dates (example: breakfast, lunch, dinner)'
        ],
        'meals_banquet' => [
            'question' => 'Was a  group banquet or reception part of this conference and was paid either in the registration or separately?',
            'label' => 'Group banquet or reception',
            'precision' => 'Please provide details, including description and amount when applicable.'
        ],
        'travel_changed' => [
            'question' => 'Did your travel plans change during trip (flight delays, came home early, etc.)?',
            'label' => 'Plans Changed',
            'precision' => 'Please provide details including description & amounts when applicable.'
        ],
        'other_funding' => [
            'question' => 'Do you have other funding (not previously included on Pre-Travel Authorization)?',
            'label' => 'Other Funding',
            'precision' => 'Please provide details including Buget Approval, description & amounts when applicable.'
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
        'foreign_currency' => [
            'question' => 'Are there charges in foreign currency?',
            'label' => 'Foreign currency',
            'precision' => 'Please use oanda.com for currency conversion & indicate the conversion amounts on the receipts.'
        ],
    ];

    private $order_id;

    public function __construct($order_id)
    {
        $this->order_id = $order_id;
        $questions = Question::where('status','active')->get();

        foreach ($questions as  $question) {
            $unserializedArray = null;
            if ($question->options){
                $unserializedArray = unserialize($question->options);
            }
            $this->notes[$question->item] = new TripNotesResponse(
                $order_id,
                $question->item,
                $question->label,
                $question->question,
                $unserializedArray ?? null,
                $question->notes ?? null
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
