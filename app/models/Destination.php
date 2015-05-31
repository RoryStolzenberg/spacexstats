<?php
class Destination extends Eloquent {
    protected $table = 'destinations';
    protected $primaryKey = 'destination_id';
    public $timestamps = false;

    // Relationships
    public function missions() {
        return $this->hasOneOrMany('missions');
    }
}