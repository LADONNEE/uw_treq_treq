<?php

namespace App\Workflows;

use App\Models\Order;
use App\Models\Stage;

class StageToTaskType
{
    private $map;

    public function __construct($map = null)
    {
        $this->map = (is_array($map)) ? $map : Stage::pluck('task_type', 'name')->all();
    }

    public function taskType($stage)
    {
        if ($stage === Order::STAGE_COMPLETE) {
            return '';
        }
        return $this->map[$stage];
    }
}
