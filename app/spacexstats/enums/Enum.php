<?php
namespace SpaceXStats\Enums;

abstract class Enum {
    public static function getKey($value) {
        $reflector = new \ReflectionClass(get_called_class());
        return $reflector->getConstant($value);
    }

    public static function toArray() {
        $reflector = new \ReflectionClass(get_called_class());
        return $reflector->getConstants();
    }
}