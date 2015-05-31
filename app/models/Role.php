<?php 
class Role extends Eloquent {

	protected $table = 'roles';
	protected $primaryKey = 'role_id';
	public $timestamps = false;

	// Relations
	public function user() {
		return $this->hasMany('users');
	}

}