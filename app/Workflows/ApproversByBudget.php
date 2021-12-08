<?php
namespace App\Workflows;

use App\Models\BudgetLookup;
use App\Models\Person;

class ApproversByBudget
{
    protected $approvers = [];
    protected $biennium;

    public function __construct($biennium = null, $cache = null)
    {
        $this->biennium = ($biennium) ?: setting('current-biennium');
        if (is_array($cache)) {
            $this->approvers = $cache;
        }
    }

    public function get($budgetno)
    {
        if (!isset($this->approvers[$budgetno])) {
            $person_id = BudgetLookup::where('budgetno', $budgetno)
                ->where('biennium', $this->biennium)
                ->value('fiscal_person_id');
            $person_id = ($person_id) ?: $this->defaultContact();
            $this->approvers[$budgetno] = $person_id;
        }
        return $this->approvers[$budgetno];
    }

    /**
     * Locate the default approver for an Unknown budget
     * Configured in application settings, through admin web interface
     * @return integer|null
     */
    private function defaultContact()
    {
        $person = Person::where('uwnetid', setting('fiscal-contact-default'))->first();
        return ($person) ? $person->person_id : null;
    }
}
