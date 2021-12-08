<?php
namespace App\Repositories;

use App\Models\Progress;

class ProgressRepository
{
    private $progress;

    public function __construct(Progress $progress)
    {
        $this->progress = $progress;
    }

    public function complete($order_id, $step, $project_id, $person_id): void
    {
        $progress = $this->progress->newQuery()->firstOrNew([
            'order_id' => $order_id,
            'step' => $step,
        ]);
        $progress->project_id = $project_id;
        $progress->completed_by = $person_id;
        $progress->save();
    }

    public function getCompleted($order_id, $project_id): array
    {
        return $this->progress->newQuery()->where('order_id', $order_id)
            ->orWhere('project_id', $project_id)
            ->pluck('step')
            ->all();
    }
}
