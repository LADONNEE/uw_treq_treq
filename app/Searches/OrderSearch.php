<?php

namespace App\Searches;

use App\Models\Order;

class OrderSearch
{
    protected $words;

    public function __construct(array $words)
    {
        $this->words = $words;
    }

    public function search()
    {
        $query = Order::select('orders.*')
            ->join('shared.uw_persons AS p', 'orders.submitted_by', '=', 'p.person_id')
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