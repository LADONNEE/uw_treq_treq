<?php

namespace App\Forms;

use App\Models\Order;
use App\Models\OrderLog;

class ProjectFolderForm extends Form
{
    private $order_id;
    private $project;

    public function __construct(Order $order)
    {
        $this->order_id = $order->id;
        $this->project = $order->project;
    }

    public function createInputs()
    {
        $this->add('url');
    }

    public function initValues()
    {
        $this->input('url')->setFormValue( $this->project->folder_url );
    }

    public function validate()
    {
        $this->check('url', function ($value, $error, $values) {
            if ($value && !filter_var($value, FILTER_VALIDATE_URL)) {
                $error('Requires a valid URL. Link to OneDrive folder.');
            }
        });
    }

    public function commit()
    {
        $url = $this->value('url');
        if ($url != $this->project->folder_url) {
            $this->project->folder_url = $url;
            $this->project->save();
            $this->logFolderChange();
        }
    }

    private function logFolderChange()
    {
        $folder = ($this->project->folder_url) ?: '(empty)';

        $log = new OrderLog([
            'order_id' => $this->order_id,
            'actor_id' => user()->person_id,
            'project_id' => $this->project->id,
            'message' => "Changed project OneDrive folder to {$folder}",
        ]);
        $log->save();
    }
}
