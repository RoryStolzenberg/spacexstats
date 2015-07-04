<?php

class Favorite extends Eloquent {

	protected $table = 'favorites_pivot';
	protected $primaryKey = 'favorite_id';
    public $timestamps = true;

    protected $hidden = [];
    protected $appends = [];
    protected $fillable = [];
    protected $guarded = [];

	// Relations
	public function users() {
		return $this->belongsTo('user');
	}

	public function object() {
		return $this->belongsTo('object');
	}
}