<?php
namespace SpaceXStats\Services;

use \Tag;

class TagActionService extends ActionServiceInteface {
    protected $tag, $errors;

    public function __construct(Tag $tag) {
        $this->tag = $tag;
    }
    public function isValid($input) {
        $tagValidation = $this->tag->isValid($input);

        if ($tagValidation === true) {
            return true;
        } else {
            $this->errors = $tagValidation;
            return false;
        }
    }

    public function make($input) {
        if (!Tag::where('name', $input['name'])->exists()) {
            Tag::create($input);
        }
    }

    public function getErrors() {
        return $this->errors;
    }
}