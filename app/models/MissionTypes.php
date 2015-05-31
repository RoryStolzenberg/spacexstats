<?php
class MissionTypes extends Eloquent {
    protected $table = 'mission_types';
    protected $primaryKey = 'mission_type_id';
    protected $timestamps = false;

    // Relationships
    public function missions() {
        return $this->hasOneOrMany('Mission');
    }
}