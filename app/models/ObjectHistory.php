<?php

class ObjectHistory extends Eloquent {
    protected $table = 'object_histories';
    protected $primaryKey = 'object_history_id';
    public $timestamps = true;

    protected $hidden = [];
    protected $appends = [];
    protected $fillable = [];
    protected $guarded = [];

    // Relationships
    public function object() {
        return $this->hasOne('Object');
    }

    public function user() {
        return $this->hasOne('User');
    }
}
