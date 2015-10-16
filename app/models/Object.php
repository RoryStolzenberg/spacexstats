<?php
namespace SpaceXStats\Models;
use Illuminate\Database\Eloquent\Model;

use SpaceXStats\Library\Enums\ObjectPublicationStatus;
use SpaceXStats\Library\Enums\VisibilityStatus;

use SpaceXStats\Models\Traits\CommentableTrait as Commentable;
use SpaceXStats\Models\Traits\UploadableTrait as Uploadable;
use SpaceXStats\Models\Traits\CountsViewsTrait as CountsViews;
use SpaceXStats\Models\Interfaces\UploadableInterface;

use SpaceXStats\Presenters\PresentableTrait as Presentable;
use SpaceXStats\Presenters\ObjectPresenter;

class Object extends Model implements UploadableInterface {

    use Presentable, Commentable, Uploadable, CountsViews;

	protected $table = 'objects';
	protected $primaryKey = 'object_id';
    public $timestamps = true;

	protected $hidden = [];
    protected $appends = ['media', 'media_thumb_large', 'media_thumb_small'];
	protected $fillable = [];
	protected $guarded = [];

    public function getDates() {
        return ['created_at', 'updated_at', 'actioned_at'];
    }

    protected $presenter = ObjectPresenter::class;

	protected $rules = array(
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

    // Observers
    public static function boot() {
        parent::boot();

        // Delete any files before deleting the object
        static::deleting(function($object) {
            $s3 = AWS::get('s3');

            if ($object->hasFile()) {
                if ($object->status === ObjectPublicationStatus::PublishedStatus) {
                    $s3->deleteObject(Credential::AWSS3Bucket, $object->filename);
                } else {
                    unlink(public_path() . $object->media);
                }
            }

            if ($object->hasThumbs()) {
                if ($object->status === ObjectPublicationStatus::PublishedStatus) {
                    $s3->deleteObject(Credential::AWSS3BucketLargeThumbs, $object->filename);
                    $s3->deleteObject(Credential::AWSS3BucketSmallThumbs, $object->filename);
                } else {
                    unlink(public_path() . $object->media_thumb_large);
                    unlink(public_path() . $object->media_thumb_small);
                }
            }

            return true;
        });
    }

    // Functions
    public function getRules() {
        return $this->rules;
    }

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

    public function comments() {
        return $this->hasMany('SpaceXStats\Models\Comment');
    }

    // Custom relations
    public function featuredImageOf() {
        return $this->hasMany('SpaceXStats\Models\Mission', 'featured_image', 'object_id');
    }

    // Scoped Queries
    public function scopeWhereQueued($query) {
        return $query->where('status', ObjectPublicationStatus::QueuedStatus)->orderBy('created_at', 'ASC');
    }

    public function scopeWherePublished($query) {
        return $query->where('status', ObjectPublicationStatus::PublishedStatus);
    }

    public function scopeWherePublic($query) {
        return $query->where('visibility', VisibilityStatus::PublicStatus);
    }

    public function scopeWhereDefault($query) {
        return $query->where('visiblility', VisibilityStatus::DefaultStatus);
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
    public function getOriginDateAsStringAttribute() {
        // Y-m-d
        $year = substr($this->originated_at, 0, 4);
        $month = substr($this->originated_at, 5, 2);
        $day = substr($this->originated_at, 8, 2);

        if ($month == '00') {
            return $year;
        } else if ($day == '00') {
            return $year . '-' . $month;
        }
        return $this->originated_at;
    }

    /**
     * @return mixed|null|string
     */
    public function getMediaAttribute() {
        if ($this->hasFile()) {

            if ($this->hasLocalFile()) {
                return $this->local_file;
            }

            if ($this->status == 'Published') {
                $s3 = AWS::get('s3');
                return $s3->getObjectUrl(Credential::AWSS3Bucket, $this->filename, '+5 minutes');

            } elseif ($this->status == 'Queued' || $this->status == 'New') {
                return '/media/full/' . $this->filename;
            }
        }
        return null;
    }

    /**
     * @return mixed
     */
    public function getMediaDownloadAttribute() {
        if ($this->hasFile()) {
            $s3 = AWS::get('s3');

            return $s3->getObjectUrl(Credential::AWSS3Bucket, $this->filename, '+5 minutes', array(
                'ResponseContentDisposition' => 'attachment; filename="' . $this->title . '.' . $this->filetype . '"'
            ));
        } else {

        }
    }

    /**
     * @return null|string
     */
    public function getMediaThumbSmallAttribute() {
        if (!empty($this->thumb_filename)) {

            if ($this->hasThumbs()) {
                if ($this->status == 'Published') {
                    $s3 = AWS::get('s3');
                    return $s3->getObjectUrl(Credential::AWSS3BucketSmallThumbs, $this->thumb_filename, '+1 minute');

                } elseif ($this->status == 'Queued' || $this->status == 'New') {
                    return '/media/small/' . $this->thumb_filename;
                }

            } else {
                return '/media/small/' . $this->thumb_filename;
            }
        }
        return null;
    }

    /**
     * @return null|string
     */
    public function getMediaThumbLargeAttribute() {
        if (!empty($this->thumb_filename)) {

            if ($this->hasThumbs()) {
                if ($this->status == 'Published') {
                    $s3 = AWS::get('s3');
                    return $s3->getObjectUrl(Credential::AWSS3BucketLargeThumbs, $this->thumb_filename, '+1 minute');

                } elseif ($this->status == 'Queued' || $this->status == 'New') {
                    return '/media/large/' . $this->thumb_filename;
                }

            } else {
                return '/media/large/' . $this->thumb_filename;
            }
        }
        return null;
    }

    public function getQueueTimeAttribute() {
        return $this->actioned_at->diffInSeconds($this->created_at);
    }

    public function getViewsAttribute() {
        return Redis::hget('object:' . $this->object_id, 'views') !== null ? Redis::hget('object:' . $this->object_id, 'views') : 0;
    }

    // Attribute mutators
    public function setAnonymousAttribute($value) {
        $this->attributes['anonymous'] = filter_var($value, FILTER_VALIDATE_BOOLEAN);
    }
}