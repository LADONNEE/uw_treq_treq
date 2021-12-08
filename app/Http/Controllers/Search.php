<?php
namespace App\Http\Controllers;

use App\Searches\GlobalSearch;

class Search extends Controller
{
    public function __invoke()
    {
        $search = new GlobalSearch(request('q'));

        $viewData = $search->getReport();
        $viewData['searchTerm'] = $search->parsedQuery;

        return view('search.index', $viewData);
    }
}
