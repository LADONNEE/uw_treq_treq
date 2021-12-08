<?php
namespace App\Searches;

class GlobalSearch
{
    public $parsedQuery;
    protected $query;

    public function __construct($query)
    {
        $this->query = $query;
    }

    public function getReport()
    {
        $words = $this->parseQuery();
        if (!$words) {
            $this->parsedQuery = '';
            return $this->emptyResults();
        }
        $this->parsedQuery = implode(' ', $words);

        $orders = (new OrderSearch($words))->search();
        $projects = (new ProjectSearch($words))->search();
        $trips = (new TripSearch($words))->search();
        $budgets = (new BudgetSearch($words))->search();
        $aribas = (new AribaSearch($words))->search();
        $count = count($orders) + count($projects) + count($trips) + count($budgets) + count($aribas);
        return [
            'count' => $count,
            'orders' => $orders,
            'projects' => $projects,
            'trips' => $trips,
            'budgets' => $budgets,
            'aribas' => $aribas,
        ];
    }

    public function emptyResults()
    {
        return [
            'count' => 0,
            'orders' => collect([]),
            'projects' => collect([]),
            'trips' => collect([]),
            'budgets' => collect([]),
            'aribas' => collect([]),
        ];
    }

    public function parseQuery()
    {
        $query = trim(strtolower($this->query));
        $query = preg_replace('/\s+/', ' ', $query);
        if ($query === '') {
            return false;
        }
        return explode(' ', $query);
    }
}
