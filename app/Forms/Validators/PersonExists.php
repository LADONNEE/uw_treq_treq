<?php
namespace App\Forms\Validators;

use App\Models\Person;
use Uworgws\Formkit\Validators\BaseValidator;

class PersonExists extends BaseValidator
{
    public function isValid(string $value, array $options): bool
    {
        $person = Person::find($value);
        return $person instanceof Person;
    }
}
