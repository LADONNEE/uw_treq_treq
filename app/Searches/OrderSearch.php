<?php

namespace App\Searches;

use App\Models\Order;
use Config;

class OrderSearch
{
    protected $words;
    private $table;

    public function __construct(array $words)
    {
        $this->words = $words;
        $this->table = Config::get('app.database_shared'); 
    }

    public function search()
    {
        $query = Order::select('orders.*')
            ->join($this->table . '.uw_persons AS p', 'orders.submitted_by', '=', 'p.person_id')
            ->orderBy('orders.created_at', 'desc')
            ->with(['project', 'submitter', 'tracking']);
        $this->addFilters($query);
        return $query->get();
    }

    public function addFilters($query)
    {
        foreach ($this->words as $word) {
            $query->where(function($query) use($word) {
                $query->where('p.lastname', 'like', "%{$word}%");
                $query->orWhere('p.firstname', 'like', "{$word}%");
                $query->orWhere('p.uwnetid', $word);
            });
        }
    }
}
