<?php
namespace App\Http\Controllers;

use App\Api\TasksApi;
use App\Models\Order;

class TaskList extends Controller
{
    public function __invoke(Order $order)
    {
        $api = new TasksApi($order, user());
        return response()->json($api->getReport());
    }
}
