<?php
namespace App\Forms;

use App\Events\StepCompleted;
use App\Events\TaskUpdated;
use App\Forms\Validators\PersonExists;
use App\Models\Order;
use App\Models\Task;
use App\Trackers\LoggedSubmit;
use App\Trackers\TaskLog;
use App\Utilities\ChooseDeptApprover;

class DepartmentApprovalForm extends Form
{
    private $order;
    private $task;

    public function __construct(Order $order)
    {
        $this->order = $order;
        $this->task = $this->getDepartmentApprovalTask($order->id);
    }

    public function createInputs()
    {
        $this->add('approval_from');
        $this->add('person_id', 'hidden')
            ->set('id', 'js-approver-person-id');
        $this->add('approver', 'person')
            ->set('data-for', 'js-approver-person-id');
        $this->add('description', 'textarea');
    }

    public function initValues()
    {
        if ($this->task->assigned_to) {
            $this->set('person_id', $this->task->assigned_to);
            $this->set('approver', eFirstLast($this->task->assigned_to));
        } else {
            $this->suggestDeptApproverByBudget();
        }
        $this->set('description', $this->task->description);
    }

    public function validate()
    {
        if ($this->value('approval_from') === 'other') {
            $this->check('person_id')->notEmpty();
            $this->check('person_id')->using(new PersonExists());
            if ($this->input('person_id')->hasError()) {
                $this->input('approver')->error($this->input('person_id')->getError());
            }
        }
    }

    public function commit()
    {
        if ($this->value('approval_from') === 'other') {
            $this->requestDepartmentApproval();
        } else {
            $this->approveByUser();
        }

        $cmd = new LoggedSubmit($this->order, user()->person_id, $this->task->id);
        $cmd->execute();

        event(new StepCompleted($this->order, 'department', user()));
        event(new TaskUpdated($this->task, user()));
    }

    private function requestDepartmentApproval()
    {
        $this->task->fill([
            'type' => Task::TYPE_DEPARTMENT,
            'name' => 'Department Approval',
            'sequence' => 1,
            'is_approval' => true,
            'description' => $this->value('description'),
            'assigned_to' => $this->value('person_id'),
            'created_by' => user()->person_id
        ]);
        $this->task->save();
    }

    private function approveByUser()
    {
        $this->task->fill([
            'type' => Task::TYPE_DEPARTMENT,
            'name' => 'Department Approval',
            'sequence' => 1,
            'is_approval' => true,
            'description' => null,
            'created_by' => user()->person_id,
            'assigned_to' => user()->person_id,
            'response' => Task::RESPONSE_APPROVED,
            'message' => null,
            'completed_by' => user()->person_id,
            'completed_at' => now(),
        ]);
        $this->task->save();

        TaskLog::write($this->task, user()->person_id, "approved {$this->task->name}");
    }

    /**
     * @param $order_id
     * @return Task
     */
    private function getDepartmentApprovalTask($order_id)
    {
        return Task::firstOrNew([
            'order_id' => $order_id,
            'type' => Task::TYPE_DEPARTMENT,
        ]);
    }

    private function suggestDeptApproverByBudget()
    {
        $dept_person_id = (new ChooseDeptApprover())->contactFor($this->order->id);
        if ($dept_person_id) {
            $this->set('person_id', $dept_person_id);
            $this->set('approver', eFirstLast($dept_person_id));
        }
    }
}
