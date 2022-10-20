<?php

namespace App\Searches;

use App\Models\Budget;
use Config;

/**
 * Search for BudgetNbrs used by Orders
 */
class BudgetSearch
{
    protected $words;
    protected $db_budgets;

    public function __construct(array $words)
    {
        $this->words = $words;
        $this->db_budgets = Config::get('app.database_budgets'); 
    }

    public function search()
    {
        $query = Budget::select($this->db_budgets . '.*')
            ->join('orders', $this->db_budgets . '.order_id', '=', 'orders.id')
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
                    $query->orWhere($this->db_budgets . '.budgetno', '=', $word);
                } elseif (preg_match('/^[0-9]{4}$/', $word)) {
                    $query->orWhere($this->db_budgets . '.budgetno', 'like', '%-' . $word);
                } else {
                    $query->orWhere($this->db_budgets . '.name', 'like', "%{$word}%");
                    $query->orWhere($this->db_budgets . '.pca_code', 'like', "%{$word}%");
                }
            });
        }
    }
}
