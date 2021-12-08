<?php
namespace App\Http\Controllers;

use App\Forms\AssignFiscalForm;
use App\Models\Order;

class FiscalController extends Controller
{
    public function edit(Order $order)
    {
        $form = new AssignFiscalForm($order);
        return view('fiscal.update', compact('order', 'form'));
    }

    public function update(Order $order)
    {
        $form = new AssignFiscalForm($order);

        if ($form->process()) {
            return redirect()->route('order', $order->id);
        }

        return redirect()->back();
    }
}
