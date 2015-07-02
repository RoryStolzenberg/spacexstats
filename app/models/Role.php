<?php 
class Role extends Eloquent {

	protected $table = 'roles';
	protected $primaryKey = 'role_id';
    public $timestamps = false;

    protected $hidden = [];
    protected $appends = [];
    protected $fillable = [];
    protected $guarded = [];

	// Relations
	public function users() {
		return $this->hasMany('User');
	}

}