<?php
namespace SpaceXStats\Managers;

use \Tag;

class TagManager {
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

    public function create($input) {
        if (!Tag::where('name', $input['name'])->exists()) {
            Tag::create($input);
        }
    }

    public function getErrors() {
        return $this->errors;
    }
}