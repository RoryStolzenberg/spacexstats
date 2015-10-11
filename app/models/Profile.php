<?php
namespace SpaceXStats\Models;

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
		return $this->belongsTo('User');
	}

    public function favoriteMission() {
        return $this->belongsTo('Mission', 'favorite_mission');
    }

    public function favoritePatch() {
        return $this->belongsTo('Object', 'favorite_mission_patch');
    }
}
