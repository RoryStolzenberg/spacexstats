<?php
namespace SpaceXStats\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model {

	protected $table = 'profiles';
	protected $primaryKey = 'user_id';
    public $timestamps = true;

    protected $hidden = [];
    protected $appends = [];
    protected $fillable = [];
    protected $guarded = ['user_id'];

	// Relations
	public function user() {
		return $this->belongsTo('SpaceXStats\Models\User');
	}

    public function favoriteMission() {
        return $this->belongsTo('SpaceXStats\Models\Mission', 'favorite_mission');
    }

    public function favoritePatch() {
        return $this->belongsTo('SpaceXStats\Models\Object', 'favorite_mission_patch');
    }
}
