<?php

class Publisher extends Eloquent {

    protected $table = 'tweeters';
    protected $primaryKey = 'tweeter_id';
    public $timestamps = false;

    protected $hidden = [];
    protected $appends = [];
    protected $fillable = [];
    protected $guarded = [];

    // Relations
    public function objects() {
        return $this->hasMany('Object');
    }
}
