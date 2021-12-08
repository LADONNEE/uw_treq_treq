<?php

namespace App\Http\Controllers;

use App\Workflows\OrderTypes as WorkflowOrderTypes;

class OrderTypes
{
    public function __invoke()
    {
        $types = (new WorkflowOrderTypes())->typesThreeByTwo();
        return view('order-types.index', compact('types'));
    }
}
