<?php

namespace App\Http\Controllers;

use App\Forms\AdvancedSearchForm;

class AdvancedSearchController extends Controller
{
    public function __invoke()
    {
        $form = new AdvancedSearchForm();

        if (request('go', false)) {
            $form->process();
        }

        $viewData = [
            'form' => $form,
            'searchRan' => $form->searchRan,
            'orders' => $form->orders,
        ];

        return view('advanced-search/index', $viewData);
    }
}
