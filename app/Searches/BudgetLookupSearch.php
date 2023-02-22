<?php

namespace App\Searches;

use App\Models\BudgetLookup;
use Config;

/**
 * Return search results from BudgetLookup table
 * Use same search parameters as the Order search by BudgetNbr
 */
class BudgetLookupSearch extends BudgetSearch
{
    private $biennium;
    protected $words;
    protected $db_budgets;

    public function __construct($biennium, $searchInput)
    {
        $this->biennium = $biennium;
        $this->db_budgets =  Config::get('app.database_budgets'); 
        parent::__construct(explode(' ', $searchInput));
    }

    public function search()
    {
        $query = BudgetLookup::select('budgets.*')->where('budgets.biennium', $this->biennium);
        $this->addFilters($query);
        $results = $query->get();

        return $results->map(function ($item, $key) {
            return [
                'id' => $item->budget_id,
                'budgetno' => $item->budgetno,
                'name' => $item->name,
            ];
        });
    }

    public function addFilters($query)
    {
        foreach ($this->words as $word) {
            $query->where(function($query) use($word){
                if (preg_match('/^[0-9]{6}$/', $word)) {
                    $word = substr($word, 0, 2) . '-' . substr($word, 2);
                }
                if (preg_match('/^[0-9][0-9]\-[0-9]{4}$/', $word)) {
                    $query->orWhere('budgets.budgetno', '=', $word);
                } elseif (preg_match('/^[0-9]{4}$/', $word)) {
                    $query->orWhere('budgets.budgetno', 'like', '%-' . $word);
                } else {
                    $query->orWhere('budgets.name', 'like', "%{$word}%");
                }
            });
        }
    }
}
