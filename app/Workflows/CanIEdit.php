<?php
namespace App\Workflows;

use App\Auth\User;
use App\Models\Order;

class CanIEdit
{
    private $isCreating;
    private $isNotResolved;
    private $userIsFiscal;
    private $userIsSubmitter;
    private $userCanEdit;

    public $ariba;
    public $cancel;
    public $contact;
    public $budgets;
    public $items;
    public $notes;
    public $project;
    public $tasks;
    public $trip_notes;

    public function __construct(Order $order, User $user)
    {
        $this->isCreating = !$order->isSubmitted() ;
        $this->isNotResolved = !$order->isComplete() && !$order->isCanceled();
        $this->userIsFiscal = hasRole('treq:fiscal', $user);
        $this->userIsSubmitter = $order->isSubmitted() && $order->submitted_by === $user->person_id;
        $this->userCanEdit = $this->isCreating || $this->userIsFiscal || $this->userIsSubmitter;

        $this->ariba = $this->userIsFiscal;
        $this->cancel = $this->isNotResolved && $this->userCanEdit;
        $this->contact = $this->isNotResolved && $this->userIsFiscal;
        $this->budgets = $this->isNotResolved && $this->userCanEdit;
        $this->items = $this->isNotResolved && $this->userCanEdit;
        $this->notes = true;
        $this->project = $this->isNotResolved && $this->userCanEdit;
        $this->tasks = true;
        $this->trip_notes = $this->isNotResolved && $this->userCanEdit;
    }
}
