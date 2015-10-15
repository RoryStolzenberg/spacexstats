<?php
namespace SpaceXStats\Facades;

use Illuminate\Support\Facades\Facade;

class BladeRenderer extends Facade {
    public static function getFacadeAccessor() {
        return 'bladeRenderer';
    }
}