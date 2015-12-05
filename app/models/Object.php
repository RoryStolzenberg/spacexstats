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
use SpaceXStats\Library\Enums\ObjectPublicationStatus;
use SpaceXStats\Library\Enums\VisibilityStatus;

use SpaceXStats\Models\Traits\CommentableTrait as Commentable;
use SpaceXStats\Models\Traits\UploadableTrait as Uploadable;
use SpaceXStats\Models\Traits\CountsViewsTrait as CountsViews;
use SpaceXStats\Models\Interfaces\UploadableInterface;

use SpaceXStats\Presenters\PresentableTrait as Presentable;
use SpaceXStats\Presenters\ObjectPresenter;
use SpaceXStats\Search\Interfaces\SearchableInterface;

class Object extends Model implements UploadableInterface, SearchableInterface {

    use Presentable, Commentable, Uploadable, CountsViews;

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

	public $rules = array(
        'user_id' => ['integer', 'exists:users,user_id'],
        'mission_id' => ['integer','exists:missions,mission_id'],

        'type' => 'integer',
        'subtype' => 'integer',

        'size' => 'integer',

        'title' => 'varchar:small',

        'dimension_width' => 'integer',
        'dimension_height' => 'integer',
        'length' => 'integer',

        'summary' => 'varchar:large',
        'author' => 'varchar:tiny',
        'attribution' => 'varchar:compact',
        'originated_at' => '',

        'ISO' => 'integer',
        'camera_manufacturer' => 'varchar:small',
        'camera_model' => 'varchar:small'
    );

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
    
    public function getId() {
        return $this->object_id;
    }
    
    public function getIndexType() {
        return 'objects';
    }
    
    public function index() {
        $paramBody = [
            'object_id' => $this->object_id,
            'user_id' => !$this->anonymous ? $this->user_id : null,
            'user' => [
                'user_id' => !$this->anonymous ? $this->user->user_id : null,
                'username' => !$this->anonymous ? $this->user->username : null
            ],
            'mission_id' => $this->mission_id,
            'type' => $this->type,
            'subtype' => $this->subtype,
            'size' => $this->size,
            'filetype' => $this->filetype,
            'title' => $this->title,
            'dimensions' => [
                'width' => $this->dimension_width,
                'height' => $this->dimension_height
            ],
            'duration' => $this->duration,
            'summary' => $this->summary,
            'author' => $this->author,
            'attribution' => $this->attribution,
            'originated_at' => $this->present()->originDateAsString(),
            'tweet_user_name' => $this->tweet_user_name,
            'tweet_text' => $this->tweet_text,
            'status' => $this->status,
            'visibility' => $this->visibility,
            'anonymous' => $this->anonymous,
            'orignal_content' => $this->originalContent,
            'actioned_at' => $this->actioned_at->toDateTimeString(),
            'tags' => $this->tags()->lists('name'),
            'favorites' => $this->favorites()->lists('user_id'),
            'notes' => $this->notes()->lists('user_id'),
            'downloads' => $this->downloads()->lists('user_id')->unique()
        ];

        if ($this->mission()->count() == 1) {
            $paramBody['mission'] = [
                'mission_id' => $this->mission->mission_id,
                'name' => $this->mission->name
            ];
        } else {
            $paramBody['mission'] = [
                'mission_id' => null,
                'name' => null
            ];
        }
        return $paramBody;
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
     * @return mixed
     */
    public function getMediaDownloadAttribute() {
        if ($this->hasFile()) {
            // scale for type and length
            return AWS::createClient('s3')->getObjectUrl(Config::get('filesystems.disks.s3.bucket'), $this->filename, '+5 minutes', array(
                'ResponseContentDisposition' => 'attachment; filename="' . $this->title . '.' . $this->filetype . '"'
            ));
        } else {

        }
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
        }
        return null;
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
        }
        return null;
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