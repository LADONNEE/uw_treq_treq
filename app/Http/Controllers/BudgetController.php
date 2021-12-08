<?php
namespace App\Http\Controllers;

use App\Api\BudgetsApi;
use App\Events\BudgetsChanged;
use App\Events\StepCompleted;
use App\Models\Order;
use App\Trackers\LoggedBudgets;

class BudgetController extends Controller
{
    public function edit(Order $order)
    {
        $this->canIEdit($order, 'budgets');
        return view('budget.edit', compact('order'));
    }

    public function update(Order $order)
    {
        $this->canIEdit($order, 'budgets');

        $cmd = new LoggedBudgets($order, request('budgets_json'), user()->person_id);
        $cmd->shouldLog = $order->shouldLog();
        $cmd->execute();

        event(new StepCompleted($order, 'budgets', user()));
        event(new BudgetsChanged($order, user()));

        return redirect()->route('next', $order->id);
    }
}
