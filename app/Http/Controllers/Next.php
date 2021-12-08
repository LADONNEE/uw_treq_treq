<?php
namespace App\Http\Controllers;

use App\Models\Order;
use App\Repositories\ProgressRepository;
use App\Workflows\RequestWorkflow;

class Next extends Controller
{
    public function __invoke(Order $order, ProgressRepository $repo)
    {
        $steps = new RequestWorkflow($repo);

        return redirect()->route($this->stepToRoute($steps->next($order)), $order->id);
    }

    private function stepToRoute($step)
    {
        switch ($step) {
            case 'project': return 'project-edit';
            case 'trip': return 'trip-edit';
            case 'show': return 'order';
            case 'attachments':
            case 'items':
            case 'trip-items':
            case 'trip-notes':
            case 'budgets':
            case 'department':
                return $step;
            default:
                abort(404, "Unknown step '{$step}'");
                return '';
        }
    }
}
