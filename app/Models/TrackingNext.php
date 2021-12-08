<?php
namespace App\Models;

class TrackingNext
{
    public $action;
    public $actors;

    public function __construct(Order $order, $taskType)
    {
        $this->action = $this->getAction($order, $taskType);
        $this->actors = $this->getActors($order->id, $taskType);
    }

    private function getAction($order, $taskType): string
    {
        if ($taskType !== 'task') {
            return $order->stage;
        }

        $task = Task::where('order_id', $order->id)
            ->where('type', $taskType)
            ->whereNull('completed_at')
            ->orderBy('created_at')
            ->first();

        return ($task instanceof Task) ? $task->name : $order->stage;
    }

    private function getActors($order_id, $taskType): string
    {
        if (!$taskType) {
            return '';
        }

        $personIds = Task::where('order_id', $order_id)
            ->where('type', $taskType)
            ->whereNull('completed_at')
            ->pluck('assigned_to')
            ->all();
        $out = [];
        foreach ($personIds as $person_id) {
            $out[] = eFirstLast($person_id);
        }
        return implode(', ', $out);
    }
}
