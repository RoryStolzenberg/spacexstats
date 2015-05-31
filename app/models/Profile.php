<?php

class Profile extends Eloquent {

	protected $table = 'profiles';
	protected $primaryKey = 'user_id';
	public $timestamps = false;

	protected $guarded = ['user_id'];

	// Relations
	public function user() {
		return $this->belongsTo('User');
	}
}
