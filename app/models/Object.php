<?php
namespace SpaceXStats\Models;

use AWS;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redis;
use Parsedown;
use SpaceXStats\Library\Enums\DateSpecificity;
use SpaceXStats\Library\Enums\MissionControlType;
use SpaceXStats\Library\Enums\ObjectPublicationStatus;
use SpaceXStats\Library\Enums\VisibilityStatus;

use SpaceXStats\Models\Traits\CommentableTrait as Commentable;
use SpaceXStats\Models\Traits\UploadableTrait as Uploadable;
use SpaceXStats\Models\Traits\CountsViewsTrait as CountsViews;
use SpaceXStats\Models\Interfaces\UploadableInterface;

use SpaceXStats\Presenters\Traits\PresentableTrait as Presentable;
use SpaceXStats\Presenters\ObjectPresenter;
use SpaceXStats\Search\Models\SearchableObject;
use SpaceXStats\Search\Traits\SearchableTrait as Searchable;

class Object extends Model implements UploadableInterface {

    use Presentable, Commentable, Uploadable, CountsViews, Searchable;

	protected $table = 'objects';
	protected $primaryKey = 'object_id';
    public $timestamps = true;

	protected $hidden = [];
    protected $appends = ['media', 'media_thumb_large', 'media_thumb_small'];
	protected $fillable = [];
	protected $guarded = [];

    protected $supportsMarkdown = [];

    public function getDates() {
        return ['created_at', 'updated_at', 'actioned_at', 'originated_at'];
    }

    protected $presenter = ObjectPresenter::class;
    protected $searchDecorator = SearchableObject::class;

	public $rules = [
        'user_id'               => ['integer', 'exists:users,user_id'],
        'mission_id'            => ['integer','exists:missions,mission_id'],

        'type'                  => 'string',
        'subtype'               => 'string',

        'title'                 => 'varchar:small',
        'summary'               => ['min:100', 'varchar:large'],
        'author'                => 'varchar:tiny',
        'attribution'           => 'varchar:compact',

        'size'                  => 'integer',
        'dimension_width'       => 'integer',
        'dimension_height'      => 'integer',
        'duration'              => 'integer',
        'page_count'            => 'integer',

        'originated_at'         => 'date',

        'tweet_id'              => ['integer', 'unique:objects'],
        'tweet_text'            => 'max:140',

        'ISO'                   => 'integer',
        'camera_manufacturer'   => 'varchar:small',
        'camera_model'          => 'varchar:small',

        'publisher_id'          => ['integer', 'exists:publishers,publisher_id']
    ];

    public $messages = [
        'tweet_id.unique' => 'That tweet has already been submitted'
    ];

	// Relations
	public function mission() {
		return $this->belongsTo('SpaceXStats\Models\Mission');
	}

	public function user() {
		return $this->belongsTo('SpaceXStats\Models\User');
	}

    public function tweeter() {
        return $this->belongsTo('SpaceXStats\Models\Tweeter');
    }

    public function publisher() {
        return $this->belongsTo('SpaceXStats\Models\Publisher');
    }

    public function tags() {
        return $this->morphToMany('SpaceXStats\Models\Tag', 'taggable', 'taggables_pivot');
    }

    public function collections() {
        return $this->belongsToMany('SpaceXStats\Models\Collection', 'collections_objects_pivot');
    }

    public function favorites() {
        return $this->hasMany('SpaceXStats\Models\Favorite');
    }

    public function notes() {
        return $this->hasMany('SpaceXStats\Models\Note');
    }

    public function downloads() {
        return $this->hasMany('SpaceXStats\Models\Download');
    }

    public function revisions() {
        return $this->hasMany('SpaceXStats\Models\ObjectRevision');
    }

    // conditional relations
    public function featuredImageOf() {
        return $this->hasMany('SpaceXStats\Models\Mission', 'featured_image', 'object_id');
    }

    // Custom methods
    public function isVisibleToUser() {
        if (Auth::isAdmin()) {
            return true;
        } else if (Auth::isSubscriber()) {
            return $this->visibility != VisibilityStatus::HiddenStatus;
        } else {
            return $this->visibility == VisibilityStatus::PublicStatus;
        }
    }

    public function isInMissionControl() {
        return $this->status != ObjectPublicationStatus::NewStatus;
    }

    // Scoped Queries
    public function scopeWherePublic($query) {
        return $query->where('visibility', VisibilityStatus::PublicStatus);
    }

    public function scopeWhereDefault($query) {
        return $query->where('visiblility', VisibilityStatus::DefaultStatus);
    }

    public function scopeInMissionControl($query) {
        return $query->where('status', '!=', ObjectPublicationStatus::NewStatus);
    }

    /**
     * Only return Objects where the visibility of the object matches the corresponding user role
     * of a user.
     *
     * @param $query
     * @return mixed
     */
    public function scopeAuthedVisibility($query) {
        if (Auth::isAdmin()) {
            return $query;
        } else if (Auth::isSubscriber()) {
            return $query->where('visibility', '!=', VisibilityStatus::HiddenStatus);
        } else {
            return $query->where('visibility', VisibilityStatus::PublicStatus);
        }
    }

    // Attribute accessors
    /**
     * Preferentially fetches the main media file from an object from the local repository, the cloud, and then the
     * temporary location, if it exists.
     *
     * @return mixed|null|string
     */
    public function getMediaAttribute() {
        if ($this->hasFile()) {

            if ($this->hasLocalFile()) {
                return '/media/local/full/' . $this->filename;
            }

            if ($this->hasCloudFile()) {
                $s3 = AWS::createClient('s3');

                $cmd = $s3->getCommand('GetObject', [
                    'Bucket' => Config::get('filesystems.disks.s3.bucket'),
                    'Key' => $this->filename,
                    'ResponseContentType' => $this->mimetype
                ]);

                return $s3->createPresignedRequest($cmd, '+1 minute')->getUri(); // Scale for type and length!
            }

            if ($this->hasTemporaryFile()) {
                return '/media/temporary/full/' . $this->filename;
            }
        }
        return null;
    }

    /**
     * @return null|string
     */
    public function getMediaThumbSmallAttribute() {

        if ($this->hasThumbs()) {
            if ($this->hasLocalThumbs()) {
                return '/media/local/small/' . $this->thumb_filename;
            }

            if ($this->hasCloudThumbs()) {
                $s3 = AWS::createClient('s3');

                $cmd = $s3->getCommand('GetObject', [
                    'Bucket' => Config::get('filesystems.disks.s3.bucketSmallThumbs'),
                    'Key' => $this->thumb_filename,
                    'ResponseContentType' => $this->mimetype
                ]);

                return $s3->createPresignedRequest($cmd, '+1 minute')->getUri(); // Scale for type and length!
            }

            if ($this->hasTemporaryThumbs()) {
                return '/media/temporary/small/' . $this->thumb_filename;
            }

        } elseif ($this->type == MissionControlType::Tweet) {
            return $this->tweeter->profilePicture;

        } else {
            if (is_null($this->subtype)) {
                return '/media/generic/small/' . $this->type . '.png';
            } else {
                return '/media/generic/small/' . $this->subtype . '.png';
            }
        }
    }

    /**
     * @return null|string
     */
    public function getMediaThumbLargeAttribute() {

        if ($this->hasThumbs()) {
            if ($this->hasLocalThumbs()) {
                return '/media/local/large/' . $this->thumb_filename;
            }

            if ($this->hasCloudThumbs()) {
                $s3 = AWS::createClient('s3');

                $cmd = $s3->getCommand('GetObject', [
                    'Bucket' => Config::get('filesystems.disks.s3.bucketLargeThumbs'),
                    'Key' => $this->thumb_filename,
                    'ResponseContentType' => $this->mimetype
                ]);

                return $s3->createPresignedRequest($cmd, '+1 minute')->getUri(); // Scale for type and length!
            }

            if ($this->hasTemporaryThumbs()) {
                return '/media/temporary/large/' . $this->thumb_filename;
            }

        } elseif ($this->type == MissionControlType::Tweet) {
            return $this->tweeter->profilePicture;

        } else {
            if (is_null($this->subtype)) {
                return '/media/generic/large/' . $this->type . '.png';
            } else {
                return '/media/generic/large/' . $this->subtype . '.png';
            }
        }
    }

    public function getQueueTimeAttribute() {
        return $this->actioned_at->diffInSeconds($this->created_at);
    }

    public function getViewsAttribute() {
        return Redis::hget('Object:' . $this->object_id, 'views') !== null ? Redis::hget('Object:' . $this->object_id, 'views') : 0;
    }

    public function getSummaryMdAttribute() {
        return Parsedown::instance()->text($this->attributes['summary']);
    }

    public function getArticleMdAttribute() {
        return Parsedown::instance()->text($this->attributes['article']);
    }

    // Attribute mutators
    public function setAnonymousAttribute($value) {
        $this->attributes['anonymous'] = filter_var($value, FILTER_VALIDATE_BOOLEAN);
    }

    public function setOriginatedAtAttribute($value) {
        if (is_null($value)) {
            return;
        }

        if (substr($value, 5, 2) === '00') {
            $this->attributes['originated_at_specificity'] = DateSpecificity::Year;
            $this->attributes['originated_at'] = Carbon::create(substr($value, 0, 4), 1, 1, 0, 0, 0);

        } elseif (substr($value, 8, 2) === '00') {
            $this->attributes['originated_at_specificity'] = DateSpecificity::Month;
            $this->attributes['originated_at'] = Carbon::create(substr($value, 0, 4), substr($value, 5, 2), 1, 0, 0, 0);

        } elseif (substr($value, 11) === '00:00:00') {
            $this->attributes['originated_at_specificity'] = DateSpecificity::Day;
            $this->attributes['originated_at'] = Carbon::create(substr($value, 0, 4), substr($value, 5, 2), substr($value, 8, 2), 0, 0, 0);

        } else {
            $this->attributes['originated_at_specificity'] = DateSpecificity::Datetime;
            $this->attributes['originated_at'] = $value;
        }
    }
}