<?php
namespace App\Events;

use App\Models\Task;

interface TaskAddedOrChanged
{
    public function getTask(): Task;
}
