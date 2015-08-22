<?php

use \SpaceXStats\Enums\LaunchSpecificity;

class Mission extends Eloquent {

	use PresentableTrait, ValidatableTrait;

	protected $table = 'missions';
	protected $primaryKey = 'mission_id';
    public $timestamps = true;

    protected $hidden = ['launch_exact', 'launch_approximate'];
    protected $appends = ['launchDateTime'];
    protected $fillable = [];
    protected $guarded = [];

    protected $presenter = "MissionPresenter";

    // Validation
    public $rules = array(
        'name' => ['sometimes', 'required', 'string', 'varchar:tiny'],
        'contractor' => ['sometimes', 'required', 'string', 'varchar:small'],
        'launch_exact' => ['sometimes', 'date_format:Y-m-d H:i:s'],
        'launch_approximate' => ['sometimes', 'required', 'string', 'varchar:tiny']
    );

    public $messages = array(
        'name.varchar' => 'The mission name needs to be shorter than :size characters'
    );

	// Relations
	public function vehicle() {
		return $this->belongsTo('Vehicle');
	}

    public function parts() {
        return $this->belongsToMany('Part', 'part_flights_pivot');
    }

    public function partFlights() {
        return $this->hasMany('PartFlight');
    }

	public function spacecraftFlight() {
		return $this->hasOne('SpacecraftFlight');
	}

    public function astronautFlights() {
        return $this->hasManyThrough('AstronautFlight', 'SpacecraftFlight');
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
        return $this->hasMany('Object');
    }

    public function payloads() {
        return $this->hasMany('Payload');
    }

    // Conditional Relationships
    public function articles() {
        return $this->hasMany('Object')->where('type', \SpaceXStats\Enums\MissionControlType::Article);
    }

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

	// Attribute Accessors
	public function getLaunchDateTimeAttribute() {
		return ($this->attributes['launch_specificity'] >= LaunchSpecificity::Day) ? $this->attributes['launch_exact'] : $this->attributes['launch_approximate'];
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
        $launchReorderer = new SpaceXStats\Library\LaunchReorderer($this, $value);
        $launchReorderer->run();
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

	public function scopeFuture($query, $take = 1) {
		return $query->whereUpcoming()->orderBy('launch_order_id')->take($take);
	}

	public function scopePast($query, $take = 1) {
		return $query->whereComplete()->orderBy('launch_order_id', 'desc')->take($take);
	}

	// Get 1 or more next launches relative to a current launch_order_id
	public function scopeNext($query, $currentLaunchOrderId, $numberOfMissionsToGet = 1) {
		return $query->where('launch_order_id', '>', $currentLaunchOrderId)
						->orderBy('launch_order_id')
						->take($numberOfMissionsToGet);
	}

	// Get 1 or more previous launches relative to a current launch_order_id
	public function scopePrevious($query, $currentLaunchOrderId, $numberOfMissionsToGet = 1) {
		return $query->where('launch_order_id', '<', $currentLaunchOrderId)
						->orderBy('launch_order_id')
						->take($numberOfMissionsToGet);
	}

	public function scopePastFromLaunchSite($query, $site) {
		return $query->whereComplete()->whereHas('launchSite', function($q) use($site) {
			$q->where('name',$site);
		})->orderBy('launch_order_id','DESC');
	}

	public function scopeFutureFromLaunchSite($query, $site) {
		$nextLaunch = $query->whereUpcoming()->whereHas('launchSite', function($q) use($site) {
			$q->where('name',$site);
		})->orderBy('launch_order_id','ASC');
	}
}