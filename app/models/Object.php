<?php

class Object extends Eloquent {

	protected $table = 'objects';
	protected $primaryKey = 'object_id';
    public $timestamps = true;

	protected $hidden = [];
    protected $appends = [];
	protected $fillable = [];
	protected $guarded = [];

    public function getDates() {
        return ['created_at', 'updated_at', 'actioned_at'];
    }

	protected $submissionRules = array(
        'All' => array(
            'user_id' => 'required|integer|exists:users,user_id',
            'mission_id' => 'integer|exists:missions,mission_id',
            'type' => 'required|integer'
        ),
		'Image' => array(
			'title' => 'required|varchar:compact',
            'summary' => 'required|varchar:large',
            'author' => 'required|varchar:small',
            'attribution' => 'required|varchar:medium',
            'ISO' => 'integer',
            'camera_manufacturer' => 'varchar:compact',
            'camera_model' => 'varchar:compact'
		),
		'GIF' => array(
            'title' => 'required|varchar:compact',
            'summary' => 'required|varchar:large',
            'author' => 'required|varchar:small',
            'attribution' => 'required|varchar:medium',
		),
		'Audio' => array(
		),
		'Video' => array(
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

    // Validators
	public function isValidForSubmission($input) {
		$type = SpaceXStats\Enums\MissionControlType::getType($input['type']);

		$validator = Validator::make($input, $this->submissionRules[$type]);
		return ($validator->passes() ? true : $validator->errors());
	}

    // Scoped Queries
    public function scopeQueued($query) {
        return $query->where('status','queued')->orderBy('created_at', 'DESC');
    }

    // Attribute accessors
    public function getThumbSmallAttribute($value) {
        return '/'.$value;
    }

    public function getThumbLargeAttribute($value) {
        return '/'.$value;
    }

    public function getQueueTimeAttribute() {
        return $this->actioned_at->diffInSeconds($this->created_at);
    }
}