<?php
namespace SpaceXStats\Library\Miscellaneous;

class PageCounter {
    protected $file;

    public function __construct($file) {
        $this->file = $file;
    }
}