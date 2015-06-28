<?php
namespace SpaceXStats\Services;

Interface CreatorServiceInterface {

    // https://laracasts.com/series/digging-in/episodes/7#
    public function isValid($input);
    public function make($input);
    public function getErrors();
}