<?php
namespace App\Utilities;

use App\Models\Person;

/**
 * Return person_id of a fiscal person to use as Order Fiscal Contact
 */
class ChooseFiscalContact
{
    public function contactFor($order_id)
    {
        $contacts = OrderContact::byOrder($order_id);

        foreach ($contacts as $contact) {
            if ($contact->fiscal_person_id) {
                return $contact->fiscal_person_id;
            }
        }

        return $this->defaultContact();
    }

    /**
     * Locate the default fiscal contact
     * Configured in application settings, through admin web interface
     * @return integer|null
     */
    private function defaultContact()
    {
        $person = Person::where('uwnetid', setting('fiscal-contact-default'))->first();
        return ($person) ? $person->person_id : null;
    }
}
