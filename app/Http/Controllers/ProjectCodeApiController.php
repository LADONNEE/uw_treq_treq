<?php
namespace App\Http\Controllers;

use App\Models\ProjectCodeLookup;
use App\Searches\ProjectCodeLookupSearch;

class ProjectCodeApiController extends Controller
{
    public function prefetch()
    {
        $out = ProjectCodeLookup::select('id', 'code', 'description')
            // ->where('biennium', setting('current-biennium'))
            // ->orderBy('budgetno')
            ->orderBy('code')
            ->get();
        return response()->json($out);
    }

    public function search()
    {
        $query = request('q');
        if (!$query) {
            return response()->json([]);
        }

        $matches = (new ProjectCodeLookupSearch(setting('current-biennium'), $query))->search();

        return response()->json($matches);
    }
}
