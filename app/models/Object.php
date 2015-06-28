<?php

class Object extends Eloquent {

	protected $table = 'objects';
	protected $primaryKey = 'object_id';
    public $timestamps = true;

	protected $hidden = [];
    //protected $appends = ['thumb_small', 'thumb_large'];
	protected $fillable = [];
	protected $guarded = [];

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
		return $this->belongsTo('mission');
	}

	public function user() {
		return $this->belongsTo('user');
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
    public function getThumbSmallAttribute() {
        // TODO: use if statements based on media type later
        return 'media/small/' . $this->attributes['filename'];
    }

    public function getThumbLargeAttribute() {
        // TODO: use if statements based on media type later
        return 'media/large/' . $this->attributes['filename'];
    }
}