<?php
namespace App\Workflows;

use App\Models\Order;
use App\Repositories\WorkflowRepository;
use App\Workflows\TaskSteps\TaskStep;
use App\Workflows\Templates\Template;

class TaskWorkflow
{
    private $repo;

    public function __construct(WorkflowRepository $repo)
    {
        $this->repo = $repo;
    }

    public function update(Order $order, ?Template $template = null): void
    {
        $steps = $this->bootSteps($order, ($template ?? $order->template())->allTaskSteps());

        foreach ($steps as $step) {
            $step->activate();
            if (!$step->isComplete()) {
                $order->stage = $step->getStage();
                $order->save();
                return;
            }
        }

        $order->complete();
    }

    /**
     * @param Order $order
     * @param array $classes
     * @return TaskStep[]
     */
    private function bootSteps(Order $order, $classes)
    {
        $out = [];
        foreach ($classes as $classname) {
            $out[] = new $classname($order, $this->repo);
        }
        return $out;
    }
}
