<?php
class MissionTypes extends Eloquent {
    protected $table = 'mission_types';
    protected $primaryKey = 'mission_type_id';
    protected $timestamps = false;

    protected $hidden = [];
    protected $appends = [];
    protected $fillable = [];
    protected $guarded = [];

    // Relationships
    public function missions() {
        return $this->hasOneOrMany('Mission');
    }
}