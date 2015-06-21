<?php
namespace SpaceXStats\Services;

Interface CreatorServiceInterface {

    public function isValid($input);
    public function make($input);
    public function getErrors();
}