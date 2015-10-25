<?php

namespace SpaceXStats\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use InvalidArgumentException;

// See: https://www.reddit.com/r/laravel/comments/2yw803/form_validation_with_child_elements/
abstract class Request extends FormRequest
{
    protected $rules    = [];
    protected $messages = [];

    /**
     * Add validation rules for an input array
     *
     * @param string $name
     * @param array  $ruleSet
     * @throws InvalidArgumentException
     */
    public function addArrayRules($name, array $ruleSet = [])
    {
        // This is the array of fields to be validated as an array
        $fields = $this->get($name);

        if (!is_null($fields) && is_array($fields) && count($fields) > 0) {

            // Loop through fields to add validation rules/messages
            foreach ($fields as $index => $group) {

                // Attach rules to input array
                foreach ($ruleSet as $field => $rules) {
                    $rules = str_replace('{index}', $index, $rules);
                    $rules = is_string($rules) ? explode('|', $rules) : $rules;

                    $this->rules[$name . '.' . $index . '.' . $field] = $rules;
                }
            }
        } else {
            throw new InvalidArgumentException('Name for addArrayValidationRules() must represent an array');
        }
    }

    /**
     * Add custom validation messages for an input array
     *
     * @param string $name
     * @param array  $messages
     * @throws InvalidArgumentException
     */
    public function addArrayMessages($name, array $messages = [])
    {
        // This is the array of fields to be validated as an array
        $fields = $this->get($name);

        if (!is_null($fields) && is_array($fields) && count($fields) > 0) {

            // Loop through fields to add validation rules/messages
            foreach ($fields as $index => $group) {

                // Attach validation messages to input array
                foreach ($messages as $field => $message) {
                    $this->messages[$name . '.' . $index . '.' . $field] = $message;
                }
            }
        } else {
            throw new InvalidArgumentException('Name for addArrayValidationMessages() must represent an array');
        }
    }
}
