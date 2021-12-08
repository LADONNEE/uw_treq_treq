<?php
namespace App\Api;

use App\Auth\User;
use App\Models\Order;
use App\Models\Task;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class TasksApi
{
    protected $order_id;
    protected $canApproveOnBehalf;
    protected $isDone;
    protected $user;
    /**
     * @var Collection
     */
    protected $report;

    public function __construct(Order $order, User $user = null)
    {
        $this->order_id = $order->id;
        $this->isDone = ($order->stage === 'complete' || $order->stage === 'canceled');
        $this->user = $user;
    }

    public function getReport()
    {
        $this->lazyLoad();
        return $this->report;
    }

    public function lazyLoad()
    {
        if ($this->report === null) {
            $this->load();
        }
    }

    public function load()
    {
        $results = Task::where('order_id', $this->order_id)
            ->orderBy(DB::raw('ISNULL(completed_at)'))
            ->orderBy('completed_at')
            ->orderBy('created_at')
            ->with(['creator', 'assignee', 'completer'])
            ->get();
        $out = [];
        foreach ($results as $task) {
            $out[] = new TasksApiItem($task, $this->user);
        }
        $this->report = collect($out);
    }

    public function needsApprovalFrom($personId)
    {
        if ($this->isDone) {
            return false;
        }
        $this->lazyLoad();
        return $this->report->contains(function ($task, $key) use($personId) {
            return (!$task->hasResponse && $task->response_by === $personId && !$task->isVoid);
        });
    }
}
