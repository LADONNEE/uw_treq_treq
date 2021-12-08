<?php

namespace App\Http\Controllers;

use App\Forms\ProjectFolderForm;
use App\Models\Order;

class ProjectFolderController extends Controller
{
    public function edit(Order $order)
    {
        $form = new ProjectFolderForm($order);
        return view('project-folder.edit', compact('order', 'form'));
    }

    public function update(Order $order)
    {
        $form = new ProjectFolderForm($order);

        if ($form->process()) {
            return redirect()->route('order', $order->id);
        }

        return redirect()->back();
    }
}
