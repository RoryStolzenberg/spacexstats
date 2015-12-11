<?php
namespace SpaceXStats\Models;
use Illuminate\Database\Eloquent\Model;

class Tweeter extends Model {

    protected $table = 'tweeters';
    protected $primaryKey = 'tweeter_id';
    public $timestamps = false;

    protected $hidden = [];
    protected $appends = [];
    protected $fillable = [];
    protected $guarded = [];

    // Relations
    public function objects() {
        return $this->hasMany('SpaceXStats\Models\Object');
    }

    // Methods
    public function saveProfilePicture() {

    }

    public function getProfilePictureAttribute() {
        return '/media/tweeters/' . $this->user_name . '.png';
    }
}
