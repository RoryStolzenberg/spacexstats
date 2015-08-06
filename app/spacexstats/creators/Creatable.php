<?php
namespace SpaceXStats\Creators;

// https://laracasts.com/series/digging-in/episodes/7#
interface Creatable {
    public function isValid($input);
    public function create();
    public function getErrors();
}