<?php
namespace App\Models;

class TrackingLast
{
    public $action;
    public $actor;
    public $at;

    public function __construct(Order $order, ?Task $task = null)
    {
        if ($task) {
            $this->setTask($task);
        } else {
            $this->setOrder($order);
        }
    }

    private function setTask(Task $task)
    {
        if ($task->response == Task::RESPONSE_SENTBACK) {
            $this->action = Task::RESPONSE_SENTBACK;
        } else {
            $this->action = $task->name;
        }
        $this->actor = eFirstLast($task->completed_by);
        $this->at = eDate($task->completed_at);
    }

    private function setOrder(Order $order)
    {
        if ($order->submitted_at) {
            $this->action = 'Submitted';
            $this->actor = eFirstLast($order->submitted_by);
            $this->at = eDate($order->submitted_at);
        } else {
            $this->action = 'Creating';
            $this->actor = eFirstLast($order->submitted_by);
            $this->at = eDate($order->created_at);
        }
    }
}
