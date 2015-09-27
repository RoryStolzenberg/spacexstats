<?php
use SpaceXStats\Library\DeltaV;

class Award extends Eloquent {

    protected $table = 'awards';
    protected $primaryKey = 'award_id';
    public $timestamps = true;

    protected $hidden = [];
    protected $appends = [];
    protected $fillable = [];
    protected $guarded = [];

    // Observers
    public static function boot() {
        parent::boot();

        Award::created(function($award) {
            $award->user->incrementSubscription(DeltaV::toSeconds($award->value));
        });
    }

    // Relationships
    public function object() {
        return $this->belongsTo('Object');
    }

    public function user() {
        return $this->belongsTo('User');
    }

    // Attribute Accessors
}
