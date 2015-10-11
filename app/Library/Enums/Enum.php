<?php
namespace SpaceXStats\Library\Enums;

abstract class Enum {

    /**
     * @var array A cache of all enum values to increase performance
     */
    protected static $cache = array();

    /**
     * Returns the names/keys and values of all the constants in the enum
     *
     * @return array
     */
    public static function toArray() {
        $class = get_called_class();

        if (!isset(self::$cache[$class])) {
            $reflector = new \ReflectionClass($class);
            self::$cache[$class] = $reflector->getConstants();
        }

        return self::$cache[$class];
    }

    /**
     * Returns the names/keys of all the constants in the enum
     *
     * @return array
     */
    public static function keys() {
        return array_keys(static::toArray());
    }

    /**
     * Returns the key of the enum from the value provided, or null if not present
     *
     * @param $value
     * @return string
     */
    public static function getKey($value) {
        return array_search($value, static::toArray(), true);
    }

    /**
     * Get the value from an enum by a string-converted key
     *
     * @param $name
     * @return mixed
     */
    public static function fromString($name) {
        $reflector = new \ReflectionClass(get_called_class());
        return $reflector->getConstant($name);
    }
}