<?php
namespace SpaceXStats\Extensions;

use Illuminate\Validation\Validator;

class ExtendedValidator extends Validator {
    public function validateVarchar($attribute, $value, $parameters) {
        return strlen($value) <= constant("SpaceXStats\\Enums\\Varchar::$parameters[0]");
    }
}