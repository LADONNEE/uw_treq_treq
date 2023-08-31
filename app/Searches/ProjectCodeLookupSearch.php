<?php

namespace App\Searches;

use App\Models\ProjectCodeLookup;


/**
 * Return search results from BudgetLookup table
 * Use same search parameters as the Order search by BudgetNbr
 */
class ProjectCodeLookupSearch //extends BudgetSearch
{
    private $biennium;
    protected $words;
    protected $table_budgets_project_codes;

    public function __construct($biennium, $searchInput)
    {
        $this->biennium = $biennium;
        $this->table_budgets_project_codes =  config('app.database_shared') . '.project_codes';
        $this->words = explode(' ', $searchInput);
    }

    public function search()
    {
        $query = ProjectCodeLookup::select($this->table_budgets_project_codes . '.*');
        $this->addFilters($query);
        $results = $query->get();

        return $results->map(function ($item, $key) {
            return [
                'id' => $item->id,
                'code' => $item->code,
                'description' => $item->description,
                'workday_code' => $item->workday_code,
                'workday_description' => $item->workday_description,
            ];
        });
    }

    public function addFilters($query)
    {
        foreach ($this->words as $word) {
            $query->where(function($query) use($word){
                
                $query->orWhere($this->table_budgets_project_codes . '.code', 'like', "%{$word}%")
                      ->orWhere($this->table_budgets_project_codes . '.description', 'like', "%{$word}%")
                      ->orWhere($this->table_budgets_project_codes . '.workday_code', 'like', "%{$word}%")
                      ->orWhere($this->table_budgets_project_codes . '.workday_description', 'like', "%{$word}%");
                
            });
        }
    }
}
