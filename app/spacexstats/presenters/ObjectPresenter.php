<?php
class ObjectPresenter {
    protected $entity;

    function __construct($entity) {
        $this->entity = $entity;
    }

    public function type() {
        return \SpaceXStats\Enums\MissionControlType::getType($this->entity->type);
    }

    public function subtype() {
        if ($this->entity->subtype) {
            return \SpaceXStats\Enums\MissionControlSubtype::getType($this->entity->subtype);
        } else {
            return "";
        }
    }

    public function created_at() {
        return $this->entity->created_at->toFormattedDateString();
    }
}
