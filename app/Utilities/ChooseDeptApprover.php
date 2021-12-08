<?php
namespace App\Utilities;

/**
 * Return person_id of a budget business contactto use as Department Approver
 */
class ChooseDeptApprover
{
    public function contactFor($order_id)
    {
        $contacts = OrderContact::byOrder($order_id);

        foreach ($contacts as $contact) {
            if ($contact->business_person_id) {
                return $contact->business_person_id;
            }
        }

        foreach ($contacts as $contact) {
            if ($contact->fiscal_person_id) {
                return $contact->fiscal_person_id;
            }
        }

        return null;
    }
}
