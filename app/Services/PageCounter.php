<?php
namespace SpaceXStats\Services;

class PageCounter {
    protected $file;

    public function __construct($file) {
        $this->file = $file;
    }
}