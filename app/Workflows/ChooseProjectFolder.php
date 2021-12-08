<?php

namespace App\Workflows;

use App\Models\Order;
use App\Models\Project;
use App\Models\Task;
use App\Models\UserFolder;

class ChooseProjectFolder
{
    /**
     * Attempt to set Project folder based on Users involved in request
     * Return true after first successful strategy assigns a folder
     * Return false if no folder was assigned
     *
     * @param Order $order
     * @return bool
     */
    public function setFolder(Order $order): bool
    {
        // 1. Use folder of the person who submitted the order
        if ($this->setFolderFor($order->project, $order->submitted_by)) {
            return true;
        }

        $deptTask = Task::where('order_id', $order->id)
            ->where('type', Task::TYPE_DEPARTMENT)
            ->where('response', Task::RESPONSE_APPROVED)
            ->first();

        // 2. Use folder of the person who is the Department Approver
        if ($deptTask && $this->setFolderFor($order->project, $deptTask->assigned_to)) {
            return true;
        }

        // 3. Use folder of the fiscal contact this order is assigned to
        if ($order->assigned_to) {
            return $this->setFolderFor($order->project, $order->assigned_to);
        }

        return false;
    }

    /**
     * Set the Project's folder to default folder of a user User identified by $person_id
     * Return true if user had a default folder and Project was updated, false otherwise
     *
     * @param Project $project
     * @param int $person_id
     * @return bool
     */
    private function setFolderFor(Project $project, $person_id): bool
    {
        $ff = UserFolder::where('person_id', $person_id)->first();

        if (!$ff instanceof UserFolder) {
            return false;
        }

        $project->folder_url = $ff->url;
        $project->folder_name = $ff->name;
        $project->save();

        return true;
    }
}
