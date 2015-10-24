<?php
namespace SpaceXStats\Validators;

use Illuminate\Support\Facades\Validator;

trait ValidatableTrait {
    public function isValid($input) {

        if (is_null($this->rules) || is_null($this->messages)) {
            throw new Exception('Please set the $rules & $messages properties on classes using ValidatableTrait.');
        }

        $validator = Validator::make($input, $this->rules, $this->messages);
        return $validator->passes() ? true : $validator->errors();
    }
}