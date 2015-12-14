<?php
namespace SpaceXStats\Models;
use Abraham\TwitterOAuth\TwitterOAuth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

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
        $twitterClient = new TwitterOAuth(Config::get('services.twitter.consumerKey'), Config::get('services.twitter.consumerSecret'), Config::get('services.twitter.accessToken'), Config::get('services.twitter.accessSecret'));

        // Fetch the URL of the user's profile picture
        $user = $twitterClient->get('users/show', ['screen_name' => $this->screen_name]);
        $profilePictureUrl = preg_replace("/_normal/", "", $user->profile_image_url);

        // Save it locally
        $profilePicture = file_get_contents($profilePictureUrl);

        create_if_does_not_exist(public_path('media/twitterprofiles'));
        file_put_contents(public_path('media/twitterprofiles/' . $this->screen_name . '.png'), $profilePicture);
    }

    public function getProfilePictureAttribute() {
        return '/media/twitterprofiles/' . $this->screen_name . '.png';
    }

    // Scoped queries
    public function scopeByScreenName($query, $screenName) {
        return $query->where('screen_name', $screenName);
    }
}
