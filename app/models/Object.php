<?php
namespace SpaceXStats\Models;

use SpaceXStats\Enums\ObjectPublicationStatus;
use SpaceXStats\Enums\VisibilityStatus;

class Object extends Model {

    use PresentableTrait;

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

    protected $presenter = "ObjectPresenter";

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

    public function incrementViewCounter() {
        // Only increment the view counter if the currunt user is a subscriber
        if (Auth::isSubscriber()) {

            // Only increment the view counter if the user has not visited in 1 hour
            if (Redis::exists('objectViewByUser:' . $this->object_id . ':' . Auth::user()->user_id)) {

                // Increment
                Redis::hincrby('object:' . $this->object_id, 'views', 1);

                // Add user to recent views
                Redis::setex('objectViewByUser:' . $this->object_id . ':' . Auth::user()->user_id, true, 3600);
            }
        }
    }

    /**
     * Checks whether the object has a file or not.
     *
     * This function does not care about the file's location, the object's status, or its visibility.
     *
     * @return bool
     */
    public function hasFile() {
        return !is_null($this->filename);
    }

    /**
     *
     */
    public function hasS3File() {
        // Check if a file exists in S3 for this object
    }

    /**
     * Checks whether the object has a copy of the full file stored locally.
     *
     * This function does not care about thumbnails, the object's status or its visibility.
     *
     * @return bool
     */
    public function hasLocalFile() {
        return !is_null($this->local_file);
    }

    /**
     * Checks whether the object has its own unique thumbnail or not.
     *
     * This function will return false if the object has a generic thumbnail or does not have a thumbnail. It does
     * not care about the thumbnail's location, the object's status, or its visibility.
     *
     * @return bool
     */
    public function hasThumbs() {
        $defaultThumbs = array("audio.png", "document.png", "text.png", "comment.png", "article.png", "pressrelease.png");
        return !is_null($this->thumb_filename) && !in_array($this->thumb_filename, $defaultThumbs);
    }

    public function hasS3Thumbs() {

    }

    /**
     *  Uploads the objects file and thumbnails, if they exist, to Amazon S3, and then unsets the temporary file.
     */
    public function putToS3() {
        $s3 = AWS::get('s3');

        if ($this->hasFile()) {
            $s3->putObject([
                'Bucket' => Credential::AWSS3Bucket,
                'Key' => $this->filename,
                'Body' => fopen(public_path() . $this->media, 'rb'),
                'ACL' =>  $this->visibility === VisibilityStatus::PublicStatus ? \Aws\S3\Enum\CannedAcl::PUBLIC_READ : \Aws\S3\Enum\CannedAcl::PRIVATE_ACCESS,
            ]);
            unlink(public_path() . $this->media);
        }

        if ($this->hasThumbs()) {
            $s3->putObject([
                'Bucket' => Credential::AWSS3BucketLargeThumbs,
                'Key' => $this->thumb_filename,
                'Body' => fopen(public_path() . $this->media_thumb_large, 'rb'),
                'ACL' =>  $this->visibility === VisibilityStatus::PublicStatus ? \Aws\S3\Enum\CannedAcl::PUBLIC_READ : \Aws\S3\Enum\CannedAcl::PRIVATE_ACCESS,
                'StorageClass' => \Aws\S3\Enum\StorageClass::REDUCED_REDUNDANCY
            ]);
            unlink(public_path() . $this->media_thumb_large);

            $s3->putObject([
                'Bucket' => Credential::AWSS3BucketSmallThumbs,
                'Key' => $this->thumb_filename,
                'Body' => fopen(public_path() . $this->media_thumb_small, 'rb'),
                'ACL' =>  \Aws\S3\Enum\CannedAcl::PUBLIC_READ,
                'StorageClass' => \Aws\S3\Enum\StorageClass::REDUCED_REDUNDANCY
            ]);
            unlink(public_path() . $this->media_thumb_small);
        }
    }

    /**
     * Deletes all files, including thumbnails, from S3, if they exist.
     */
    public function deleteFromS3() {
        $s3 = AWS::get('s3');

        if ($this->hasFile()) {
            if ($this->status === ObjectPublicationStatus::PublishedStatus) {
                $s3->deleteObject(Credential::AWSS3Bucket, $this->filename);
            }
        }

        if ($this->hasThumbs()) {
            if ($this->status === ObjectPublicationStatus::PublishedStatus) {
                $s3->deleteObject(Credential::AWSS3BucketLargeThumbs, $this->filename);
                $s3->deleteObject(Credential::AWSS3BucketSmallThumbs, $this->filename);
            }
        }
    }

    /**
     * Makes a local copy of a file of an object from S3.
     *
     * The function does not currently support the creation of local files from temporary files.
     */
    public function makeLocalFile() {
        if (!$this->hasLocalFile()) {
            if ($this->hasFile()) {
                AWS::get('s3')->getObject(array(
                    'Bucket'    => Credential::AWSS3Bucket,
                    'Key'       => $this->filename,
                    'SaveAs'    => public_path() . '/media/local/' . $this->filename
                ));

                $this->local_file = '/media/local/' . $this->filename;
                $this->save();
            }
        }
    }

    /**
     * Deletes the current local file.
     */
    public function deleteLocalFile() {
        if ($this->hasLocalFile()) {
            unlink(public_path() . $this->local_file);
            $this->local_file = null;
            $this->save();
        }
    }

	// Relations
	public function mission() {
		return $this->belongsTo('Mission');
	}

	public function user() {
		return $this->belongsTo('User');
	}

    public function tweeter() {
        return $this->belongsTo('Tweeter');
    }

    public function publisher() {
        return $this->belongsTo('Publisher');
    }

    public function tags() {
        return $this->morphToMany('Tag', 'taggable', 'taggables_pivot');
    }

    public function collections() {
        return $this->belongsToMany('Collection', 'collections_objects_pivot');
    }

    public function favorites() {
        return $this->hasMany('Favorite');
    }

    public function notes() {
        return $this->hasMany('Note');
    }

    public function downloads() {
        return $this->hasMany('Download');
    }

    public function comments() {
        return $this->hasMany('Comment');
    }

    // Custom relations
    public function featuredImageOf() {
        return $this->hasMany('Mission', 'featured_image', 'object_id');
    }

    // Scoped Queries
    public function scopeWhereQueued($query) {
        return $query->where('status', ObjectPublicationStatus::QueuedStatus)->orderBy('created_at', 'ASC');
    }

    public function scopeWherePublished($query) {
        return $query->where('status', ObjectPublicationStatus::PublishedStatus);
    }

    public function scopeAuthedStatus($query) {
        if (!Auth::isAdmin()) {
            return $query->where('status', ObjectPublicationStatus::PublishedStatus);
        }
        return $query;
    }

    public function scopeWherePublic($query) {
        return $query->where('visibility', VisibilityStatus::PublicStatus);
    }

    public function scopeWhereDefault($query) {
        return $query->where('visiblility', VisibilityStatus::DefaultStatus);
    }

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

    public function getCommentTreeAttribute() {
        return $this->buildTree($this->comments()->withTrashed()->with('user')->get()->toArray(), 0);
    }

    private function buildTree($array, $parent, $currentDepth = 0) {
        $branch = [];

        // http://stackoverflow.com/questions/8587341/recursive-function-to-generate-multidimensional-array-from-database-result
        foreach ($array as $model) {
            $model['depth'] = $currentDepth;
            if ($model['parent'] == $parent) {
                $children = $this->buildTree($array, $model['comment_id'], $currentDepth + 1);

                if ($children) {
                    $model['children'] = $children;
                }

                $branch[] = $model;
            }
        }
        return $branch;
    }

    // Attribute mutators
    public function setAnonymousAttribute($value) {
        $this->attributes['anonymous'] = filter_var($value, FILTER_VALIDATE_BOOLEAN);
    }
}