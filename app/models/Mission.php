<?php
namespace SpaceXStats\Models;

use Illuminate\Database\Eloquent\Model;
use SpaceXStats\Library\Enums\LaunchSpecificity;
use SpaceXStats\Library\Enums\MissionControlType;
use SpaceXStats\Library\Enums\MissionStatus;
use SpaceXStats\Library\Launch\LaunchReorderer;
use SpaceXStats\Mail\MailQueues\MissionMailQueue;
use SpaceXStats\Presenters\MissionPresenter;
use SpaceXStats\Presenters\PresentableTrait;
use SpaceXStats\Validators\ValidatableTrait;
use Parsedown;

class Mission extends Model {

	use PresentableTrait, ValidatableTrait;

	protected $table = 'missions';
	protected $primaryKey = 'mission_id';
    public $timestamps = true;

    protected $hidden = ['launch_exact', 'launch_approximate'];
    protected $appends = ['launchDateTime'];
    protected $fillable = [];
    protected $guarded = [];

    protected $presenter = MissionPresenter::class;

    // Observers
    public static function boot() {
        parent::boot();

        $missionMailQueuer = new MissionMailQueue();

        Mission::created(function($mission) use ($missionMailQueuer) {
            // Add emails to queue
            $missionMailQueuer->newMission($mission);

            // Add to RSS

            // Tweet about it
        });

        Mission::updating(function($mission) use ($missionMailQueuer) {
            // If  the launch date time has changed
            /*if ($) {
                // Send out a new email
                $missionMailQueuer->launchTimeChange($mission);

                // Add to RSS

                // Tweet about it
            }*/
        });
    }

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
		return $this->belongsTo('SpaceXStats\Models\Vehicle');
	}

    public function parts() {
        return $this->belongsToMany('SpaceXStats\Models\Part', 'part_flights_pivot');
    }

    public function partFlights() {
        return $this->hasMany('SpaceXStats\Models\PartFlight');
    }

	public function spacecraftFlight() {
		return $this->hasOne('SpaceXStats\Models\SpacecraftFlight');
	}

    public function astronautFlights() {
        return $this->hasManyThrough('SpaceXStats\Models\AstronautFlight', 'SpacecraftFlight');
    }

	public function launchSite() {
		return $this->belongsTo('SpaceXStats\Models\Location', 'launch_site_id');
	}

	public function prelaunchEvents() {
		return $this->hasMany('SpaceXStats\Models\PrelaunchEvent');
	}

    public function destination() {
        return $this->belongsTo('SpaceXStats\Models\Destination');
    }

    public function missionType() {
        return $this->belongsTo('SpaceXStats\Models\MissionType');
    }

    public function objects() {
        return $this->hasMany('SpaceXStats\Models\Object');
    }

    public function payloads() {
        return $this->hasMany('SpaceXStats\Models\Payload');
    }

    public function telemetries() {
        return $this->hasMany('SpaceXStats\Models\Telemetry');
    }

    // Conditional Relationships
    public function articles() {
        return $this->hasMany('SpaceXStats\Models\Object')->where('type', MissionControlType::Article);
    }

    public function launchVideo() {
        return $this->belongsTo('SpaceXStats\Models\Object', 'launch_video');
    }

    public function missionPatch() {
        return $this->belongsTo('SpaceXStats\Models\Object', 'mission_patch');
    }

    public function pressKit() {
        return $this->belongsTo('SpaceXStats\Models\Object', 'press_kit');
    }

    public function cargoManifest() {
        return $this->belongsTo('SpaceXStats\Models\Object', 'cargo_manifest');
    }

    public function prelaunchPressConference() {
        return $this->belongsTo('SpaceXStats\Models\Object', 'prelaunch_press_conference');
    }

    public function postlaunchPressConference() {
        return $this->belongsTo('SpaceXStats\Models\Object', 'postlaunch_press_conference');
    }

    public function featuredImage() {
        return $this->belongsTo('SpaceXStats\Models\Object', 'featured_image');
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

    public function getArticleAttribute() {
        return Parsedown::instance()->text($this->attributes['article']);
    }

    // Attribute Mutators
    public function setNameAttribute($value) {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = strtolower(str_replace(' ', '-', $value));
    }

    public function setLaunchDateTimeAttribute($value) {
        $launchReorderer = new LaunchReorderer($this, $value);
        $launchReorderer->run();
    }

	// Slug helper
	public function scopeWhereSlug($query, $slug) {
		return $query->where('slug', $slug);
	}

	// Scoped Queries
	public function scopeWhereComplete($query, $inclusive = false) {
        if ($inclusive) {
            return $query->where('status', MissionStatus::Complete)->orWhere('status', MissionStatus::InProgress);
        }
		return $query->where('status', MissionStatus::Complete);
	}

	public function scopeWhereUpcoming($query, $inclusive = false) {
        if ($inclusive) {
            return $query->where('status', MissionStatus::Upcoming)->orWhere('status', MissionStatus::InProgress);
        }
		return $query->where('status', MissionStatus::Upcoming);
	}

	public function scopeFuture($query) {
		return $query->whereUpcoming()->orderBy('launch_order_id');
	}

	public function scopePast($query) {
		return $query->whereComplete()->orderBy('launch_order_id', 'desc');
	}

	// Get 1 or more next launches relative to a current launch_order_id
	public function scopeNext($query, $currentLaunchOrderId) {
		return $query->where('launch_order_id', '>', $currentLaunchOrderId)
						->orderBy('launch_order_id');
	}

	// Get 1 or more previous launches relative to a current launch_order_id
	public function scopePrevious($query, $currentLaunchOrderId) {
		return $query->where('launch_order_id', '<', $currentLaunchOrderId)
						->orderBy('launch_order_id', 'DESC');
	}

	public function scopePastFromLaunchSite($query, $site) {
		return $query->whereComplete()->whereHas('launchSite', function($q) use($site) {
			$q->where('name',$site);
		})->orderBy('launch_order_id','DESC');
	}

	public function scopeFutureFromLaunchSite($query, $site) {
		return $query->whereUpcoming()->whereHas('launchSite', function($q) use($site) {
			$q->where('name',$site);
		})->orderBy('launch_order_id','ASC');
	}

    public function scopeWhereSpecificVehicle($query, $vehicle) {
        return $query->whereHas('vehicle', function($q) use($vehicle) {
             $q->where('vehicle', $vehicle);
        });
    }

    public function scopeWhereGenericVehicle($query, $vehicle) {
        return $query->whereHas('vehicle', function($q) use ($vehicle) {
            $q->where('vehicle', 'like', ($vehicle == 'Falcon 9') ? $vehicle . '%' : $vehicle);
        });
    }
}