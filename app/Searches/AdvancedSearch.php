<?php

namespace App\Searches;

use App\Models\Order;
use Illuminate\Support\Facades\DB;

class AdvancedSearch
{
    /**
     * This configuration maps search form inputs to columns on the advanced_search_view table
     *
     *  0 => HTML input name= property on search form
     *  1 => SQL comparison operator used to compare user input to database column
     *  2 => column(s) searched for this value, if this is an array all of the columns are
     *       searched using OR conjunction
     *  3 => value preparation, wildcard gets %percents% at front and back
     * @var array
     */
    private $searchFields = [
        ['start_date', '>=', 'submitted_at', 'date'],
        ['end_date', '<=', 'submitted_at', 'date'],
        ['project_title', 'like', 'title', 'wildcard'],
        ['project_owner', 'like', ['order_submitter', 'project_owner'], 'wildcard'],
        ['traveler', 'like', 'traveler', 'wildcard'],
        ['depart', '>=', 'depart_at', 'date'],
        ['return', '<=', 'return_at', 'date'],
        ['reference_number', 'like', 'ref', 'wildcard'],
        ['items', 'like', 'item_name', 'wildcard'],
        ['budget_id', '=', 'budgetno', 'exact'],
        ['pca_code', 'like', 'pca_code', 'wildcard'],
    ];

    /**
     * @var AdvancedSearchParam[]
     */
    private $queryParams;

    public function __construct(array $userInput)
    {
        $this->buildParameters($userInput);
    }

    public function search()
    {
        if (count($this->queryParams) === 0) {
            return [];
        }

        $matchingOrders = DB::table('advanced_search_view');

        foreach ($this->queryParams as $param) {
            $param->addFilter($matchingOrders);
        }

        return Order::whereIn('id', $matchingOrders->distinct()->pluck('order_id'))
            ->orderBy('submitted_at', 'desc')
            ->get();
    }

    /**
     * Find search parameters that have user input and create AdvanceSearchParam objects
     * @param array $input
     */
    private function buildParameters(array $input)
    {
        $this->queryParams = [];
        foreach ($this->searchFields as $f) {
            $name = $f[0];
            if (isset($input[$name]) && $input[$name] !== '') {
                $this->queryParams[] = new AdvancedSearchParam($name, $input[$name], $f[1], $f[2], $f[3]);
            }
        }
    }

    public function hasParameters(): bool
    {
        return count($this->queryParams) > 0;
    }
}
