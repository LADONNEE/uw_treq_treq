<?php
namespace App\Listeners;

use App\Events\TaskAddedOrChanged;
use App\Models\Person;
use App\Utilities\UserImporter;

class AuthorizeApprover
{
    public function handle(TaskAddedOrChanged $event)
    {
        $responder = $event->task->assignee;
        if ($responder instanceof Person && $responder->uwnetid) {
            $import = new UserImporter($responder->uwnetid);
            $import->authorize();
        }
    }
}
