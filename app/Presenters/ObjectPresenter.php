<?php
namespace SpaceXStats\Presenters;

use SpaceXStats\Library\Enums\MissionControlSubtype;
use SpaceXStats\Library\Enums\MissionControlType;

class ObjectPresenter {
    protected $entity;

    function __construct($entity) {
        $this->entity = $entity;
    }

    public function type() {
        return MissionControlType::getKey($this->entity->type);
    }

    public function subtype() {
        return $this->entity->subtype ? MissionControlSubtype::getKey($this->entity->subtype) : null;
    }

    public function size() {
        $prefixes = ['B', 'KB', 'MB', 'GB'];
        $size = $this->entity->size;
        $i = 0;

        while ($size >= 1000) {
            $size /= 1000;
            $i++;
        }

        return round($size, 1) . ' ' . $prefixes[$i];
    }

    public function originDateAsString() {
        // Y-m-d
        $year = substr($this->entity->originated_at, 0, 4);
        $month = substr($this->entity->originated_at, 5, 2);
        $day = substr($this->entity->originated_at, 8, 2);

        if ($month == '00') {
            return $year;
        } else if ($day == '00') {
            return jdmonthname($month, 0) . " " . $year;
        }
        return \Carbon\Carbon::parse($this->entity->originated_at)->toFormattedDateString();
    }
}