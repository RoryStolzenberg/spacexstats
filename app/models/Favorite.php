<?php

class Favorite extends Eloquent {

	protected $table = 'favorites';
	protected $primaryKey = 'favorite_id';
    protected $timestamps = true;

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