<?php

class Favorite extends Eloquent {

	protected $table = 'favorites';
	protected $primaryKey = 'favorite_id';
    public $timestamps = true;

    protected $hidden = [];
    protected $appends = [];
    protected $fillable = [];
    protected $guarded = [];

	// Relations
	public function user() {
		return $this->belongsTo('User');
	}

	public function object() {
		return $this->belongsTo('Object');
	}
}