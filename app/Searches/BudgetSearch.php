<?php

namespace App\Searches;

use App\Models\Budget;

/**
 * Search for BudgetNbrs used by Orders
 */
class BudgetSearch
{
    protected $words;
    protected $budgets_table;

    public function __construct(array $words)
    {
        $this->words = $words;
        $this->budgets_table = 'budgets'; 
    }

    public function search()
    {
        $query = Budget::select($this->budgets_table . '.*')
            ->join('orders', $this->budgets_table . '.order_id', '=', 'orders.id')
            ->orderBy('orders.created_at', 'desc')
            ->with('order')
            ->with('order.project')
            ->with('order.submitter');
        $this->addFilters($query);
        return $query->get();
    }

    public function addFilters($query)
    {
        foreach ($this->words as $word) {
            $query->where(function($query) use($word){
                if (preg_match('/^[0-9]{6}$/', $word)) {
                    $word = substr($word, 0, 2) . '-' . substr($word, 2);
                }
                if (preg_match('/^[0-9][0-9]\-[0-9]{4}$/', $word)) {
                    $query->orWhere($this->budgets_table . '.budgetno', '=', $word);
                } elseif (preg_match('/^[0-9]{4}$/', $word)) {
                    $query->orWhere($this->budgets_table . '.budgetno', 'like', '%-' . $word);
                } else {
                    $query->orWhere($this->budgets_table . '.name', 'like', "%{$word}%");
                }
            });
        }
    }
}
