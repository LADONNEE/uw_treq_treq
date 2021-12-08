<?php
namespace App\Forms;

use App\Events\ProjectUpdated;
use App\Events\StepCompleted;
use App\Models\Order;
use App\Models\Project;
use App\Trackers\LoggedProject;
use App\Utilities\ProjectTitleGenerator;

class ProjectForm extends Form
{
    protected $order;
    protected $project;

    public function __construct(Order $order)
    {
        $this->order = $order;
        $this->order->submitted_by = user()->person_id;
        $this->project = ($order->project) ?: new Project();
    }

    public function createInputs()
    {
        $this->add('title');
        $this->add('purpose', 'textarea');
        $this->add('person_id', 'hidden');
        $this->add('owner_search');
        $this->add('is_food', 'radio')->options([
            '0' => 'No food',
            '1' => 'Food will be purchased as part of this project'
        ]);
        $this->add('rsp_option', 'radio')->options([
            '0' => 'No research subject payments',
            '1' => 'Gift card research subject payments',
            '2' => 'Revolving fund check research subject payments'
        ]);
    }

    public function initValues()
    {
        $this->fill($this->project);
        $this->set('rsp_option', $this->toRspOption());
        if ($this->project->exists) {
            $this->fill([
                'owner_search' => ($this->project->person_id) ? eFirstLast($this->project->person_id) : '',
            ]);
        } else {
            $gen = new ProjectTitleGenerator();
            $this->fill([
                'title' => $gen->title($this->order),
                'person_id' => user()->person_id,
                'owner_search' => eFirstLast(user()),
            ]);
        }
    }

    private function toRspOption()
    {
        if ($this->project->is_gift_card) {
            return 1;
        }
        if ($this->project->is_rsp) {
            return 2;
        }
        return 0;
    }

    public function validate()
    {
        $this->check('purpose')->notEmpty();
    }

    public function commit()
    {
        $data = $this->all();
        $data['is_gift_card'] = ($data['rsp_option'] == 1) ? 1 : 0;
        $data['is_rsp'] = ($data['rsp_option'] == 2) ? 1 : 0;

        $cmd = new LoggedProject($this->order, $this->project, $data, user()->person_id);
        $cmd->shouldLog = $this->order->shouldLog();
        $cmd->execute();

        event(new StepCompleted($this->order, 'project', user()));
        event(new ProjectUpdated($this->project, $this->order, user()));
    }
}
