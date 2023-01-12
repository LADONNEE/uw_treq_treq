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
use App\Models\ProjectCodeLookup;

class TaskUpdate extends Controller
{
    public function __invoke(Order $order)
    {
        $this->canIEdit($order, 'tasks');

        $data = request()->all();
        $form = $this->getForm($order,$data['action'] ?? 'missing', $data['task_id'] ?? null, $data['old_budget_pcacode'] ?? null, $data['updated_budget'] ?? null);

        if ($data['action'] == "budget-update") {
            return response()->json();
        }
        else if ($form->process($data)) {
            $api = new TasksApiItem($form->task, user());
            return response()->json($api);
        }

        return response()->json([
            'result' => 'error',
            'messages' => $form->getErrors()
        ], 400);
    }

    private function getForm(Order $order, $type, $task_id, $oldBudgetPcaCode = null, $newBudget = null)
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
            case 'budget-update':
                $task = $this->getTaskByOrderIdAndName($order->id, "Department Approval | " . $oldBudgetPcaCode);


                if($task != null && $task?->type == "department"){
                    //Update task name
                    $task->name = "Department Approval | " . $newBudget["pca_code"] ; //updated-budget-pcacode

                    //Update task assignee
                    $assigned_to = $this->getProjectCode($newBudget["project_code_id"])->authorizer_person_id;
                    $task->assigned_to = $assigned_to;
                    $task->notified_at = null;
                    $task->response = null;
                    $task->completed_by = null;
                    $task->completed_at = null;
                    $task->created_by = user()->person_id;

                    //Update task with Budget information
                    $task->budgetno = $newBudget["budgetno"];
                    

                    $task->save();
                }
                return $task;
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

    /**
     * @param int $order_id
     * @param string $name
     * @return Task
     */
    private function getTaskByOrderIdAndName($order_id, $task_name)
    {
        return Task::where('order_id', $order_id)
                    ->where('name', $task_name)
                    ->first();
    }

    /**
     * @param int $pca_code_id
     * @return ProjectCodeLookup
     */
    private function getProjectCode($pca_code_id)
    {
        return ProjectCodeLookup::find($pca_code_id);
    }

}
