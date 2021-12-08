<?php

namespace App\Forms;

use App\Forms\Validators\TypeaheadHasId;
use App\Models\Order;
use App\Searches\AdvancedSearch;
use Carbon\Carbon;

class AdvancedSearchForm extends Form
{
    /**
     * Search results will be exposed here after form validation and successful search
     * @var Order[]
     */
    public $orders = [];

    public $searchRan = false;

    public function createInputs()
    {
        $this->add('start_date', 'text')
            ->date();
        $this->add('end_date', 'text')
            ->date();
        $this->add('project_title', 'text');
        $this->add('project_owner', 'text');
        $this->add('submitted_by', 'text');
        $this->add('traveler', 'text');
        $this->add('depart', 'text')
            ->date();
        $this->add('return', 'text')
            ->date();
        $this->add('reference_number', 'text');
        $this->add('items', 'text');
        $this->add('budget_id', 'hidden');
        $this->add('budget_search');
        $this->add('pca_code', 'text');
    }

    public function initValues()
    {
        $this->fill([
            'start_date' => eDate(Carbon::now()->subYear()),
            'end_date' => eDate(Carbon::now()),
        ]);
    }

    public function validate()
    {
        $id = $this->value('budget_id');
        $search = $this->value('budget_search');

        $this->check('budget_search')->using(new TypeaheadHasId($id, $search));
    }

    public function commit()
    {
        $advancedSearch = new AdvancedSearch($this->all());
        if ($advancedSearch->hasParameters()) {
            $this->orders = $advancedSearch->search();
            $this->searchRan = true;
        }
    }
}
