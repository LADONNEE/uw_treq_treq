<?php

namespace App\Searches;

use App\Models\WorktagLookup;

/**
 * Return search results from BudgetLookup table
 * Use same search parameters as the Order search by BudgetNbr
 */
class WorktagLookupSearch extends WorktagSearch
{
    //private $biennium;
    protected $words;

    public function __construct(/*$biennium,*/ $searchInput)
    {
        //$this->biennium = $biennium;
        parent::__construct(explode(' ', $searchInput));
    }

    public function search()
    {
        $query = WorktagLookup::select('worktags.*'); //->where('budgets.biennium', $this->biennium);
        $this->addFilters($query);
        $results = $query->get();

        return $results->map(function ($item, $key) {
            return [
                'id' => $item->id,
                'workday_code' => $item->workday_code,
                'name' => $item->name,
            ];
        });
    }

    public function addFilters($query)
    {
        foreach ($this->words as $word) {
            $query->where(function($query) use($word){
                    $query->orWhere('worktags.workday_code', 'like', "%{$word}%");
                    $query->orWhere('worktags.name', 'like', "%{$word}%");
            });
        }
    }
}
