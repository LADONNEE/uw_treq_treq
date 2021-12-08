<?php
namespace App\Trackers;

class LoggedApproval extends LoggedUpdate
{

    protected $fields = [
        'response' => null,
        'message' => null,
    ];

    public function label()
    {
        if ($this->model->stage === 'department') {
            return 'department approval';
        }
        if ($this->model->stage === 'hr') {
            return 'HR approval';
        }
        if ($this->model->stage === 'fiscal') {
            return 'fiscal approval';
        }
        if ($this->model->stage === 'sent-back') {
            return 'sent back';
        }
        return 'approval';
    }

    public function request(array $data)
    {
        $this->model->fill($data);
        $this->model->editedBy($this->actor_id);
        $this->model->save();

        $log = $this->newLog();
        $label = $this->label();
        $name = eFirstLast($this->model->response_by);
        $log->message = "requested {$label} from {$name}";
        $log->save();
    }

    public function approval($response, $message)
    {
        $this->model->respond($response, $message, $this->actor_id);
        $this->model->save();

        $label = $this->label();
        $log = $this->newLog();
        $log->message = "responded {$response} for {$label}";
        $log->save();
    }

    public function approvalOnly($user, $stage, $response, $message)
    {
        $this->model->responseOnly($user, $stage, $response, $message);
        $this->model->save();

        $label = $this->label();
        $log = $this->newLog();
        $log->message = "added {$response} for {$label}";
        $log->save();
    }

    public function sentBack($response, $message)
    {
        $this->model->respond($response, $message, $this->actor_id);
        $this->model->save();

        $label = $this->label();
        $log = $this->newLog();
        $log->message = "responded Sent Back for {$label}";
        $log->save();
    }

    public function sentForward($message)
    {
        $this->model->respond('Sent Forward', $message, $this->actor_id);
        $this->model->save();

        $label = $this->label();
        $log = $this->newLog();
        $log->message = "responded Sent Forward for {$label}";
        $log->save();
    }

    public function cancel($name)
    {
        $this->model->delete();

        $label = $this->label();
        $log = $this->newLog();
        $log->message = "canceled request for {$label} from {$name}";
        $log->save();
    }
}
