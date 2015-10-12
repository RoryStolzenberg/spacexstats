<?php
namespace SpaceXStats\Models;
use Illuminate\Database\Eloquent\Model;
class Role extends Model {

	protected $table = 'roles';
	protected $primaryKey = 'role_id';
    public $timestamps = false;

    protected $hidden = [];
    protected $appends = [];
    protected $fillable = [];
    protected $guarded = [];

	// Relations
	public function users() {
		return $this->hasMany('SpaceXStats\Models\User');
	}

}