<?php
namespace SpaceXStats\Facades;

use Illuminate\Support\Facades\Facade;

class Upload extends Facade {
    public static function getFacadeAccessor() {
        return 'upload';
    }
}
