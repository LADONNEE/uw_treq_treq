<?php
namespace App\Workflows;

use App\Events\StepCompleted;
use App\Models\Order;
use App\Repositories\ProgressRepository;
use App\Workflows\Templates\Template;

class RequestWorkflow
{
    /**
     * Possible steps that may be included in an Action Template and the UI description of the step
     * @var array
     */
    public static $steps = [
        'project' => 'Project',
        'trip' => 'Trip',
        'travel-items' => 'Travel Items',
        'budgets' => 'Budgets',
        'department' => 'Deparment Approval',
    ];

    /**
     * Steps that need to be completed once for the shared Project, not per Action
     * @var array
     */
    private static $projectSteps = [
        'project',
        'trip',
    ];

    private $repo;

    public function __construct(ProgressRepository $repo)
    {
        $this->repo = $repo;
    }

    public function complete(StepCompleted $event): void
    {
        $action_id = $event->order->id;
        $step = $event->step;
        $project_id = ($this->isProjectStep($step)) ? $event->order->project_id : null;
        $person_id = $event->user->person_id;

        $this->repo->complete($action_id, $step, $project_id, $person_id);
    }

    private function isProjectStep($step)
    {
        return in_array($step, self::$projectSteps);
    }

    public function next(Order $order, ?Template $template = null): string
    {
        $template = $template ?? $order->template();
        $steps = $template->requestSteps();
        $complete = $this->repo->getCompleted($order->id, $order->project_id);

        foreach ($steps as $step) {
            if (!in_array($step, $complete)) {
                return $step;
            }
        }

        // if all creation steps are complete, return project show
        return 'show';
    }
}
