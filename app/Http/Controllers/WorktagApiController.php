<?php
namespace App\Http\Controllers;

use App\Models\WorktagLookup;
use App\Searches\WorktagLookupSearch;

class WorktagApiController extends Controller
{
    public function prefetch()
    {
        $out = WorktagLookup::select('id', 'workday_code', 'name')
            ->orderBy('workday_code')
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

        $matches = (new WorktagLookupSearch(/*setting('current-biennium'),*/ $query))->search();

        return response()->json($matches);
    }
}
