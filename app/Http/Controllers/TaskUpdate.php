<?php
namespace App\Http\Controllers;

use App\Api\TasksApiItem;
use App\Forms\ApprovalApprovedForm;
use App\Forms\ApprovalCreateForm;
use App\Forms\ApprovalSentBackForm;
use App\Forms\ReassignTaskForm;
use App\Forms\TaskCompletedForm;
use App\Forms\TaskCreateForm;
use App\Forms\TaskDeleteForm;
use App\Models\Order;
use App\Models\Task;

class TaskUpdate extends Controller
{
    public function __invoke(Order $order)
    {
        $this->canIEdit($order, 'tasks');

        $data = request()->all();
        $form = $this->getForm($order,$data['action'] ?? 'missing', $data['task_id'] ?? null);

        if ($form->process($data)) {
            $api = new TasksApiItem($form->task, user());
            return response()->json($api);
        }

        return response()->json([
            'result' => 'error',
            'messages' => $form->getErrors()
        ], 400);
    }

    private function getForm(Order $order, $type, $task_id)
    {
        switch ($type) {
            case 'task':
                return new TaskCreateForm($order);
            case 'approval':
                return new ApprovalCreateForm($order);
            case 'complete':
                $task = $this->getTask($task_id);
                if (!$task->canComplete(user())) {
                    abort(403, 'Not authorized to complete this task');
                }
                return new TaskCompletedForm($this->getTask($task_id));
            case 'approve':
                $task = $this->getTask($task_id);
                if (!$task->canComplete(user())) {
                    abort(403, 'Not authorized to respond to this approval');
                }
                return new ApprovalApprovedForm($this->getTask($task_id));
            case 'send-back':
                $task = $this->getTask($task_id);
                if (!$task->canComplete(user())) {
                    abort(403, 'Not authorized to respond to this approval');
                }
                return new ApprovalSentBackForm($this->getTask($task_id));
            case 'reassign':
                $task = $this->getTask($task_id);
                if (!$task->canReassign(user())) {
                    abort(403, 'Task can not be reassigned');
                }
                return new ReassignTaskForm($task);
            case 'delete':
                $task = $this->getTask($task_id);
                if (!$task->canDelete(user())) {
                    abort(403, 'Not authorized to delete this task');
                }
                return new TaskDeleteForm($this->getTask($task_id));
            default:
                abort(404, "Unexpected action '{$type}'");
        }
    }

    /**
     * @param int $task_id
     * @return Task
     */
    private function getTask($task_id)
    {
        return Task::findOrFail($task_id);
    }
}
