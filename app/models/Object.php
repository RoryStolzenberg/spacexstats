<?php

class Object extends Eloquent {

    use PresentableTrait;

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

    protected $presenter = "ObjectPresenter";

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

    public function favorites() {
        return $this->hasMany('Favorite');
    }

    public function userFavorite() {
        return $this->hasOne('Favorite')->where('user_id', Auth::user()->user_id);
    }

    public function notes() {
        return $this->hasMany('Note');
    }

    public function userNote() {
        return $this->hasOne('Note')->where('user_id', Auth::user()->user_id);
    }

    // Validators
	public function isValidForSubmission($input) {
		$type = SpaceXStats\Enums\MissionControlType::getType($input['type']);

		$validator = Validator::make($input, $this->submissionRules[$type]);
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
    public function getFilenameAttribute($value) {
        return '/media/full/'.$value;
    }

    public function getThumbSmallAttribute($value) {
        return '/'.$value;
    }

    public function getThumbLargeAttribute($value) {
        return '/'.$value;
    }

    public function getQueueTimeAttribute() {
        return $this->actioned_at->diffInSeconds($this->created_at);
    }

    // Attribute mutators
    public function setAnonymousAttribute($value) {
        $this->attributes['anonymous'] = filter_var($value, FILTER_VALIDATE_BOOLEAN);
    }
}