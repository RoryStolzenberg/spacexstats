<?php
namespace SpaceXStats\Uploads;

class Upload {
    private $errors, $objects, $files;

    public function __construct(Checker $checker) {
        $this->checker = $checker;
    }

    public function check($files) {
        $this->files = $files;

        // Check files for errors, push any errors to the errors array
        $i = 0;
        foreach ($this->files as $file) {

            if ($this->checker->check($file)) {
                $this->objects[$i] = $this->checker->create();
            } else {
                $this->errors[$i] = $this->checker->errors();
            }
            $i++;
        }

        return $this;
    }

    public function hasErrors() {
        return !empty($this->errors);
    }

    // Turn the error codes and constants into messages.
    public function getErrors() {
        return $this->errors;
    }

    // Call this to create an upload, and add it to the database
    public function create() {
        if (!$this->hasErrors()) {

            $returnableObjects = [];

            foreach ($this->objects as $object) {
                array_push($returnableObjects, $object->addToMissionControl());
            }

            return $returnableObjects;
        } else {
            throw new Exception("We cannot add an object to Mission Control when the files array has errors");
        }
    }
}