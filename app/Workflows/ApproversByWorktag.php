<?php
namespace App\Workflows;

use App\Models\WorktagLookup;
use App\Models\Person;

class ApproversByWorktag
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

    public function get($wd_costcenter)
    {
        if (!isset($this->approvers[$wd_costcenter])) {
            $person_id = WorktagLookup::where('workday_code', $wd_costcenter)
                //->where('biennium', $this->biennium)
                ->value('fiscal_person_id');
            $person_id = ($person_id) ?: $this->defaultContact();
            $this->approvers[$wd_costcenter] = $person_id;
        }
        return $this->approvers[$wd_costcenter];
    }

    /**
     * Locate the default approver for an Unknown budget/cost center
     * Configured in application settings, through admin web interface
     * @return integer|null
     */
    private function defaultContact()
    {
        $person = Person::where('uwnetid', setting('fiscal-contact-default'))->first();
        return ($person) ? $person->person_id : null;
    }
}
