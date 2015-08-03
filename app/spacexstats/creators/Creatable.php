<?php
namespace SpaceXStats\Creators;

interface Creatable {
    public function isValid($input);
    public function create($input);
    public function getErrors();
}