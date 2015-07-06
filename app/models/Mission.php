<?php

class Mission extends Eloquent {

	use PresentableTrait;

	protected $table = 'missions';
	protected $primaryKey = 'mission_id';
    public $timestamps = false;

    protected $hidden = ['launch_date_time'];
    protected $appends = ['launch_date_time'];
    protected $fillable = [];
    protected $guarded = [];

    public $rules = array(
        'name' => 'sometimes|varchar:small',
        'launch_exact' => 'sometimes|date_format:Y-m-d H:i:s',
        'launch_approximate' => 'sometimes|string|varchar:compact'
    );

    public $messages = array(
        'name.varchar' => 'The mission name needs to be shorter than :size characters'
    );

	protected $presenter = "MissionPresenter";

	// Relations
	public function vehicle() {
		return $this->belongsTo('Vehicle');
	}

    public function cores() {
        return $this->belongsToMany('Core', 'uses');
    }

    public function uses() {
        return $this->hasMany('Uses');
    }

	public function spacecraftFlight() {
		return $this->hasOne('SpacecraftFlight');
	}

	public function launchSite() {
		return $this->belongsTo('Location', 'launch_site_id');
	}

	public function prelaunchEvents() {
		return $this->hasMany('PrelaunchEvent');
	}

    public function destination() {
        return $this->belongsTo('Destination');
    }

    public function missionType() {
        return $this->belongsTo('MissionType');
    }

    public function objects() {
        return $this->belongsTo('Object');
    }

    // Conditional Relationships
    public function launchVideo() {
        return $this->belongsTo('Object', 'launch_video');
    }

    public function missionPatch() {
        return $this->belongsTo('Object', 'mission_patch');
    }

    public function pressKit() {
        return $this->belongsTo('Object', 'press_kit');
    }

    public function cargoManifest() {
        return $this->belongsTo('Object', 'cargo_manifest');
    }

    public function prelaunchPressConference() {
        return $this->belongsTo('Object', 'prelaunch_press_conference');
    }

    public function postlaunchPressConference() {
        return $this->belongsTo('Object', 'postlaunch_press_conference');
    }

    public function redditDiscussion() {
        return $this->belongsTo('Object', 'reddit_discussion');
    }

    public function featuredImage() {
        return $this->belongsTo('Object', 'featured_image')->select(['object_id', 'filename']);
    }

    // Validation
    // One day, add a complex custom validation rule to ensure launch_approximate is validated correctly
    public function isValid($input) {
        $validator = Validator::make($input, $this->rules, $this->messages);
        return $validator->passes() ? true : $validator->errors();
    }

	// Attribute Accessors
	public function getLaunchDateTimeAttribute() {
		return ($this->attributes['launch_approximate'] == null) ? $this->attributes['launch_exact'] : $this->attributes['launch_approximate'];
	}

	public function getLaunchProbabilityAttribute() {

	}

    public function getSpecificVehicleCountAttribute() {
        $self = $this;

        return Mission::where('launch_order_id','<=',$this->launch_order_id)->whereHas('vehicle', function($q) use($self) {
            $q->where('vehicle', $self->vehicle->vehicle);
        })->count();
    }

    public function getGenericVehicleCountAttribute() {
        $self = $this;

        if (strpos($this->vehicle,'Falcon 9')) {
        	return Mission::where('launch_order_id','<=',$this->launch_order_id)->whereHas('vehicle',function($q) use($self) {
        		$q->where('vehicle','LIKE','Falcon 9%');
        	})->count();
        } else {
            return Mission::where('launch_order_id','<=',$this->launch_order_id)->whereHas('vehicle', function($q) use($self) {
                $q->where('vehicle', $self->vehicle->vehicle);
            })->count();
        }
    }

    public function getFlightGraphAttribute() {

    }

    public function getLaunchOfYearAttribute() {

    }

    public function getSuccessfulConsecutiveLaunchAttribute() {

    }

    public function getLaunchIlluminationAttribute() {

    }

    // Attribute Mutators
    public function setNameAttribute($value) {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = strtolower(str_replace(' ', '-', $value));
    }

    public function setLaunchDateTimeAttribute($value) {
        $launchReorderer = new LaunchReorderer($value, $this->launch_order_id);
        $this->attributes['launch_approximate'] = "June";
    }

	// Slug helper
	public function scopeWhereSlug($query, $slug) {
		return $query->where('slug', $slug);
	}

	// Scoped Queries
	public function scopeWhereComplete($query) {
		return $query->where('status', 'Complete');
	}

	public function scopeWhereUpcoming($query) {
		return $query->where('status', 'Upcoming');
	}

	public function scopeNextMissions($query, $take = 1) {
		return $query->whereUpcoming()->orderBy('launch_order_id')->take($take);
	}

	public function scopePreviousMissions($query, $take = 1) {
		return $query->whereComplete()->orderBy('launch_order_id', 'desc')->take($take);
	}

	// Get 1 or more future launches relative to a current launch_order_id
	public function scopeFutureMissions($query, $currentLaunchOrderId, $numberOfMissionsToGet = 1) {
		return $query->where('launch_order_id', '>', $currentLaunchOrderId)
						->orderBy('launch_order_id')
						->take($numberOfMissionsToGet);
	}

	// Get 1 or more previous launches relative to a current launch_order_id
	public function scopePastMissions($query, $currentLaunchOrderId, $numberOfMissionsToGet = 1) {
		return $query->where('launch_order_id', '<', $currentLaunchOrderId)
						->orderBy('launch_order_id')
						->take($numberOfMissionsToGet);
	}

	public function scopeLastFromLaunchSite($query, $site) {
		return $query->whereComplete()->whereHas('launchSite', function($q) use($site) {
			$q->where('name',$site);
		})->orderBy('launch_order_id','DESC');
	}

	public function scopeNextFromLaunchSite($query, $site) {
		$nextLaunch = $query->whereUpcoming()->whereHas('launchSite', function($q) use($site) {
			$q->where('name',$site);
		})->orderBy('launch_order_id','ASC');
	}
}