<?php
class ObjectPresenter {
    protected $entity;

    function __construct($entity) {
        $this->entity = $entity;
    }

    public function type() {
        return \SpaceXStats\Enums\MissionControlType::getKey($this->entity->type);
    }

    public function subtype() {
        if ($this->entity->subtype) {
            return \SpaceXStats\Enums\MissionControlSubtype::getKey($this->entity->subtype);
        } else {
            return null;
        }
    }

    public function created_at() {
        return $this->entity->created_at->toFormattedDateString();
    }
}
