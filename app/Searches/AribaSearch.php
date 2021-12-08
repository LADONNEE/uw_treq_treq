<?php

namespace App\Searches;

use App\Models\Ariba;
use App\Models\Order;

class AribaSearch
{
    protected $words;

    public function __construct(array $words)
    {
        $this->words = $words;
    }

    public function search()
    {
        $query = Ariba::query()->distinct();
        foreach ($this->words as $word) {
            $query->where('ref', 'LIKE', "%{$word}%");
        }

        $ids = $query->pluck('order_id');

        if (count($ids) === 0) {
            return collect([]);
        }

        return Order::select('orders.*')
            ->whereIn('id', $ids)
            ->orderBy('orders.created_at', 'desc')
            ->with(['project', 'submitter', 'tracking'])
            ->get();
    }
}
