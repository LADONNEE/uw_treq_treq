<?php
namespace App\Utilities;

use App\Models\Order;
use Illuminate\Support\Facades\DB;

class PurgeOrder
{
    private $order_id;
    private $project_id;
    private $childTables = [
        'ariba',
        'budgets',
        'items',
        'mail_logs',
        'notes',
        'perdiems',
        'order_logs',
        'tasks',
        'tracking',
        'progress',
    ];

    public function __construct(Order $order)
    {
        $this->order_id = $order->id;
        $this->project_id = $order->project_id;
    }

    public function purge()
    {
        if (!$this->order_id) {
            return;
        }

        $this->deleteChildRecords();
        $this->deleteOrder();

        if (!$this->project_id) {
            return;
        }

        $this->deleteProjectIfEmpty();
    }

    private function deleteChildRecords()
    {
        foreach ($this->childTables as $table) {
            DB::statement("DELETE FROM `{$table}` WHERE order_id = {$this->order_id}");
        }
    }

    private function deleteOrder()
    {
        DB::statement("DELETE FROM orders WHERE id = {$this->order_id}");
    }

    private function deleteProjectIfEmpty()
    {
        $orders = DB::table('orders')
            ->where('project_id', $this->project_id)
            ->count();

        if ($orders === 0) {
            DB::statement("DELETE FROM trips WHERE project_id = {$this->project_id}");
            DB::statement("DELETE FROM projects WHERE id = {$this->project_id}");
        }
    }
}
