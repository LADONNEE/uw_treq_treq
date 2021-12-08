<?php

namespace App\Updaters;

use App\Models\Order;
use App\Models\Stage;
use App\Repositories\WorkflowRepository;
use App\Workflows\TaskSteps\OptionalStageStep;
use App\Workflows\TaskSteps\SimpleTaskStep;
use App\Workflows\TaskSteps\TaskStep;

class UpdateStagesJob
{
    const NAMESPACE = 'App\\Workflows\\TaskSteps';

    private $ignoreBaseClasses = [
        TaskStep::class,
        SimpleTaskStep::class,
        OptionalStageStep::class,
    ];
    private $order;
    private $repo;

    public function run()
    {
        $this->order = new Order();
        $this->repo = new WorkflowRepository();

        $dir = new \DirectoryIterator(base_path('app/Workflows/TaskSteps'));
        foreach ($dir as $fileinfo) {
            if (!$fileinfo->isDot()) {
                $classname = self::NAMESPACE . '\\' . str_replace('.php', '', $fileinfo->getBasename());
                if (!in_array($classname, $this->ignoreBaseClasses)) {
                    $this->fillStageMetadata($classname);
                }
            }
        }
    }

    private function fillStageMetadata($classname)
    {
        echo '. updating ', $classname, "\n";

        $step = new $classname($this->order, $this->repo);

        if ($step->stage === '(unknown stage)') {
            echo 'x bad step configuration in ', get_class($step), "\n";
            return;
        }

        $stage = Stage::firstOrNew(['name' => $step->stage]);
        $stage->task_type = $step->taskType;
        $stage->save();
    }
}
