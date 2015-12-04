<?php
namespace SpaceXStats\Presenters;

use Carbon\Carbon;
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
        return Carbon::parse($this->entity->originated_at)->toFormattedDateString();
    }

    public function youtubeExternalUrl() {
        if (!is_null($this->entity->external_url)) {
            if (preg_match('/https?:\/\/(?:www\.)?(?:youtube\.com\/watch\?v=|youtu\.be\/)([^\s]+)\/?/', $this->entity->external_url, $externalUrl) === 1) {
                return $externalUrl[1];
            }
        }
        return false;
    }

    public function vimeoExternalUrl() {
        if (!is_null($this->entity->external_url)) {
            if (preg_match('/https?:\/\/(?:www\.)?vimeo\.com\/([^\s]+)\/?/', $this->entity->external_url, $externalUrl) === 1) {
                return $externalUrl[1];
            }
        }
        return false;
    }
}