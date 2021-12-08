<?php
namespace App\Http\Controllers;

use App\Models\BudgetLookup;
use App\Searches\BudgetLookupSearch;

class BudgetApiController extends Controller
{
    public function prefetch()
    {
        $out = BudgetLookup::select('budget_id as id', 'budgetno', 'name')
            ->where('biennium', setting('current-biennium'))
            ->orderBy('budgetno')
            ->orderBy('name')
            ->get();
        return response()->json($out);
    }

    public function search()
    {
        $query = request('q');
        if (!$query) {
            return response()->json([]);
        }

        $matches = (new BudgetLookupSearch(setting('current-biennium'), $query))->search();

        return response()->json($matches);
    }
}
