<?php

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

	protected $submissionRules = array(
        'All' => array(
            'user_id' => 'required|integer|exists:users,user_id',
            'mission_id' => 'integer|exists:missions,mission_id',
            'type' => 'required|integer',
            'originated_at' => 'required',
            'title' => 'required|varchar:compact',
            'summary' => 'required|varchar:large',
            'author' => 'required|varchar:small',
            'attribution' => 'required|varchar:medium'
        ),
		'Image' => array(
            'ISO' => 'integer',
            'camera_manufacturer' => 'varchar:compact',
            'camera_model' => 'varchar:compact'
		),
		'GIF' => array(
            'length' => 'required|integer'
		),
		'Audio' => array(
            'length' => 'required|integer'
		),
		'Video' => array(
            'length' => 'required|integer'
		),
		'Document' => array(
		),
		'Tweet' => array(
		),
		'Article' => array(
		),
		'Comment' => array(
		),
		'Update' => array(
		)
	);

    // Functions
    public function hasFile() {
        return !is_null($this->filename);
    }

    public function hasThumbs() {
        return !is_null($this->thumb_filename) && $this->thumb_filename !== "audio.png" && $this->thumb_filename !== "document.png";
    }

    public function putToS3() {
        $s3 = AWS::get('s3');

        if ($this->hasFile()) {
            $s3->putObject([
                'Bucket' => Credential::AWSS3Bucket,
                'Key' => $this->filename,
                'Body' => fopen(public_path() . $this->media, 'rb'),
                'ACL' =>  \Aws\S3\Enum\CannedAcl::PRIVATE_ACCESS,
            ]);
            unlink(public_path() . $this->media);
        }

        if ($this->hasThumbs()) {
            $s3->putObject([
                'Bucket' => Credential::AWSS3BucketLargeThumbs,
                'Key' => $this->thumb_filename,
                'Body' => fopen(public_path() . $this->media_thumb_large, 'rb'),
                'ACL' =>  \Aws\S3\Enum\CannedAcl::PRIVATE_ACCESS,
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

    public function tags() {
        return $this->belongsToMany('Tag', 'objects_tags_pivot');
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

    // Validators
	public function isValidForSubmission($input) {
		$type = SpaceXStats\Enums\MissionControlType::getType($input['type']);

		$validator = Validator::make($input, array_merge($this->submissionRules['All'], $this->submissionRules[$type]));
		return ($validator->passes() ? true : $validator->errors());
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
                $s3->getObjectUrl(Credential::AWSS3Bucket, $this->filename, '+5 minutes');

            } elseif ($this->status == 'Queued' || $this->status == 'New') {
                return '/media/full/' . $this->filename;
            }
        }
        return null;
    }

    public function getMediaThumbSmallAttribute() {
        if (!empty($this->thumb_filename)) {
            if ($this->thumb_filename == 'audio.png' || $this->thumb_filename == 'document.png') {
                return '/media/small/audio.png';
            } else {
                if ($this->status == 'Published') {
                    $s3 = AWS::get('s3');
                    $s3->getObjectUrl(Credential::AWSS3Bucket, $this->thumb_filename, '+1 minute');

                } elseif ($this->status == 'Queued' || $this->status == 'New') {
                    return '/media/small/' . $this->thumb_filename;
                }
            }
        }
        return null;
        return '/media/small/' . $this->thumb_filename;
    }

    public function getMediaThumbLargeAttribute() {
        if (!empty($this->thumb_filename)) {
            if ($this->thumb_filename == 'audio.png' || $this->thumb_filename == 'document.png') {
                return '/media/large/audio.png';
            } else {
                if ($this->status == 'Published') {
                    $s3 = AWS::get('s3');
                    $s3->getObjectUrl(Credential::AWSS3Bucket, $this->thumb_filename, '+1 minute');

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

    // Attribute mutators
    public function setAnonymousAttribute($value) {
        $this->attributes['anonymous'] = filter_var($value, FILTER_VALIDATE_BOOLEAN);
    }
}