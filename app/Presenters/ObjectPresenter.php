<?php
namespace SpaceXStats\Presenters;

use Carbon\Carbon;
use SpaceXStats\Library\Enums\DateSpecificity;
use SpaceXStats\Library\Enums\MissionControlSubtype;
use SpaceXStats\Library\Enums\MissionControlType;

class ObjectPresenter {
    protected $entity;

    function __construct($entity) {
        $this->entity = $entity;
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
        switch ($this->entity->originated_at_specificity) {
            case DateSpecificity::Datetime:
                return $this->entity->originated_at->format('g:i:sA F j, Y');
            case DateSpecificity::Day:
                return $this->entity->originated_at->format('F j, Y');
            case DateSpecificity::Month:
                return $this->entity->originated_at->format('F Y');
            case DateSpecificity::Year:
                return $this->entity->originated_at->format('Y');
            default:
                return null;
        }
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