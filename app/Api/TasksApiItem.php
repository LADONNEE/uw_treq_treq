<?php
namespace App\Api;

use App\Auth\User;
use App\Models\Task;

class TasksApiItem
{
    public $id;
    public $creator;
    public $createdAt;
    public $type;
    public $name;
    public $sequence;
    public $isApproval;
    public $budgetno;
    public $description;
    public $assigned_to;
    public $assignee;
    public $response;
    public $responseType;
    public $message;
    public $isComplete;
    public $completer;
    public $completedAt;
    public $behalf;
    public $canComplete;
    public $canReassign;
    public $canDelete;
    public $taskSummary;
    public $responseSummary;
    public $isVoid;
    public $icon;

    public function __construct(Task $task, User $user = null)
    {
        $this->fill($task, $user);
    }

    public function fill(Task $task, User $user = null)
    {
        $this->id = $task->id;
        $this->creator = "{$task->creator->firstname} {$task->creator->lastname}";
        $this->createdAt = $task->created_at->format('D, n/j/Y, g:i A');
        $this->type = $task->type;
        $this->name = $task->name;
        $this->sequence = $task->sequence;
        $this->isApproval = (bool) $task->is_approval;
        $this->budgetno = $task->budgetno;
        $this->description = $task->description;
        $this->assigned_to = $task->assigned_to;
        $this->assignee = $task->assignee ? "{$task->assignee->firstname} {$task->assignee->lastname}" : "(not assigned)";
        $this->response = $task->response;
        $this->message = $task->message;
        $this->isComplete = $task->isComplete();
        $this->canComplete = $task->canComplete($user);
        $this->canReassign = $task->canReassign($user);
        $this->canDelete = $task->canDelete($user);
        $this->isVoid = false;

        if ($this->isComplete) {
            $this->completedAt = $task->completed_at->format('D, n/j/Y, g:i A');
            $this->completer = "{$task->completer->firstname} {$task->completer->lastname}";
            $this->responseType = $this->responseType($task->response);
        } else {
            $this->completedAt = null;
            $this->completer = null;
            $this->responseType = 'unknown';
        }

        if ($this->isComplete && $task->completed_by !== $task->assigned_to) {
            $this->behalf = ", on behalf of {$task->assignee->firstname} {$task->assignee->lastname}";
        } else {
            $this->behalf = null;
        }

        $this->taskSummary = $this->summarizeRequest($task);
        $this->responseSummary = $this->summarizeResponse($task);
    }

    public function iconClasses()
    {
        $classes = ['fas'];
        switch ($this->response) {
            case 'Approved':
                $classes[] = 'fa-thumbs-up text-success';
                break;
            case 'Sent Back':
                $classes[] = 'fa-undo text-danger';
                break;
            case 'Completed':
                $classes[] = 'fa-check text-success';
                break;
            default:
                $classes[] = 'fa-question-circle';
                break;
        }
        return implode(' ', $classes);
    }

    public function responseType($response)
    {
        switch ($response) {
            case 'Approved':
                return 'yes';
            case 'Sent Back':
                return 'no';
            case 'Completed':
                return 'complete';
            default:
                return 'unknown';
        }
    }

    public function summarizeResponse(Task $task)
    {
        if ($this->isComplete) {
            return "{$this->response} by {$this->completer}";
        }
        return "Needs response from {$this->assignee}";
    }

    public function summarizeRequest(Task $task)
    {
        if ($this->isApproval) {
            return "{$this->creator} requested approval from {$this->assignee}";
        }
        return "{$this->creator} assigned task to {$this->assignee}";
    }
}
