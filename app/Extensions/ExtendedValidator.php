<?php
namespace SpaceXStats\Extensions;

use Illuminate\Validation\Validator;
use SpaceXStats\Library\Enums\Varchar;

class ExtendedValidator extends Validator {
    public function validateVarchar($attribute, $value, $parameters) {
        return strlen($value) <= Varchar::fromString($parameters[0]);
    }

    public function validateIsLaunchDateTime($attribute, $value, $parameters) {

    }
}