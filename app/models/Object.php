<?php

use SpaceXStats\Enums\ObjectPublicationStatus;
use SpaceXStats\Enums\VisibilityStatus;

class Object extends Eloquent {

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
        'user_id' => 'integer|exists:users,user_id',
        'mission_id' => 'integer|exists:missions,mission_id',

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

    public function hasFile() {
        return !is_null($this->filename);
    }

    public function hasThumbs() {
        return !is_null($this->thumb_filename) && $this->thumb_filename !== "audio.png" && $this->thumb_filename !== "document.png" && $this->thumb_filename !== "text.png";
    }

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

    // Scoped Queries
    public function scopeQueued($query) {
        return $query->where('status','queued')->orderBy('created_at', 'ASC');
    }

    public function scopePublished($query) {
        return $query->where('status','published');
    }

    public function scopePublic($query) {
        return $query->where('visibility', 'public');
    }

    public function scopeDefault($query) {
        return $query->where('visiblility', 'default');
    }

    // Attribute accessors
    public function getMediaAttribute() {
        if (!empty($this->filename)) {
            if ($this->status == 'Published') {
                $s3 = AWS::get('s3');
                return $s3->getObjectUrl(Credential::AWSS3Bucket, $this->filename, '+5 minutes');

            } elseif ($this->status == 'Queued' || $this->status == 'New') {
                return '/media/full/' . $this->filename;
            }
        }
        return null;
    }

    public function getMediaDownloadAttribute() {
        if ($this->hasFile()) {
            $s3 = AWS::get('s3');

            return $s3->getObjectUrl(Credential::AWSS3Bucket, $this->filename, '+5 minutes', array(
                'ResponseContentDisposition' => 'attachment; filename="' . $this->title . '.' . $this->filetype . '"'
            ));
        } else {

        }

    }

    public function getMediaThumbSmallAttribute() {
        if (!empty($this->thumb_filename)) {
            if ($this->thumb_filename == 'audio.png' || $this->thumb_filename == 'document.png' || $this->thumb_filename == 'text.png') {
                return '/media/small/' . $this->thumb_filename;
            } else {
                if ($this->status == 'Published') {
                    $s3 = AWS::get('s3');
                    return $s3->getObjectUrl(Credential::AWSS3BucketSmallThumbs, $this->thumb_filename, '+1 minute');

                } elseif ($this->status == 'Queued' || $this->status == 'New') {
                    return '/media/small/' . $this->thumb_filename;
                }
            }
        }
        return null;
    }

    public function getMediaThumbLargeAttribute() {
        if (!empty($this->thumb_filename)) {
            if ($this->thumb_filename == 'audio.png' || $this->thumb_filename == 'document.png' || $this->thumb_filename == 'text.png') {
                return '/media/large/' . $this->thumb_filename;
            } else {
                if ($this->status == 'Published') {
                    $s3 = AWS::get('s3');
                    return $s3->getObjectUrl(Credential::AWSS3BucketLargeThumbs, $this->thumb_filename, '+1 minute');

                } elseif ($this->status == 'Queued' || $this->status == 'New') {
                    return '/media/large/' . $this->thumb_filename;
                }
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