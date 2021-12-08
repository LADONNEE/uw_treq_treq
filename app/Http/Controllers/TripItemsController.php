<?php
namespace App\Http\Controllers;

use App\Api\PerdiemApi;
use App\Events\StepCompleted;
use App\Models\Order;
use App\Trackers\LoggedItems;
use App\Trackers\LoggedPerdiem;

class TripItemsController extends Controller
{
    public function edit(Order $order)
    {
        $this->canIEdit($order, 'items');

        $usgsaUrl = 'https://www.gsa.gov/travel/plan-book/per-diem-rates';

        return view('trip-items.edit', compact('order', 'usgsaUrl'));
    }

    public function update(Order $order)
    {
        $this->canIEdit($order, 'items');

        $cmd = new LoggedItems($order, request('items_json'), user()->person_id);
        $cmd->shouldLog = $order->shouldLog();
        $cmd->execute();

        $api = new PerdiemApi($order);
        $patch = $api->patch(request()->all());

        $cmd = new LoggedPerdiem($api->perdiem, $patch, user()->person_id);
        $cmd->shouldLog = $order->shouldLog();
        $cmd->execute();

        event(new StepCompleted($order, 'trip-items', user()));

        return redirect()->route('next', $order->id);
    }
}
