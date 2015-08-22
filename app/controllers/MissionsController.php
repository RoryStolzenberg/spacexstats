<?php
use SpaceXStats\Services\MissionCreatorService;
use SpaceXStats\MailQueues\MissionMailQueue;
use SpaceXStats\Mailers\MissionNotificationsMailer;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class MissionsController extends BaseController {

    protected $missionCreator;

    public function __construct(MissionCreatorService $missionCreator, MissionMailQueue $missionQueuer) {
        $this->missionCreator = $missionCreator;
        $this->missionQueuer = $missionQueuer;
    }

	// GET 
	// /missions/{slug}
	public function get($slug) {

        $mission = Mission::whereSlug($slug)->first();

        $pastMission = Mission::previous($mission->launch_order_id, 1)->first(['mission_id', 'slug', 'name']);
        $futureMission = Mission::next($mission->launch_order_id, 1)->first(['mission_id', 'slug', 'name']);

        $data = array(
            'mission' => $mission,
            'pastMission' => $pastMission,
            'futureMission' => $futureMission
        );

		if ($mission->status === 'Upcoming' || $mission->status === 'In Progress') {
            JavaScript::put([
                'slug' => $mission->slug,
                'launchDateTime' => $mission->present()->launchDateTime(DateTime::ISO8601),
                'launchSpecificity' => $mission->launch_specificity,
                'webcast' => Redis::hgetall('webcast')
            ]);

			return View::make('missions.futureMission', $data);
		}
		return View::make('missions.pastMission', $data);

	}

	// GET
	// missions/future
	public function future() {
		$futureLaunches = Mission::where('status','=','Upcoming')
                                    ->orWhere('status','In Progress')
									->orderBy('launch_order_id')
									->with('vehicle')->get();
		$nextLaunch = $futureLaunches->shift();

		return View::make('missions.future', array(
			'futureLaunches' => $futureLaunches,
			'nextLaunch' => $nextLaunch
		));
	}

    // GET
    // missions/past
	public function past() {
		$pastLaunches = Mission::where('status','=','Complete')->orWhere('status','=','In Progress')
									->with('vehicle')->get();

		return View::make('missions.past', array(
			'pastLaunches' => $pastLaunches
		));
	}

    // GET
    // missions/{slug}/edit
    public function edit($slug) {
        if (Request::isMethod('get')) {
            if (!Request::ajax()) {
                return View::make('missions.edit');
            } else {

            }
        } elseif (Request::isMethod('post')) {

        }
    }

    // GET
    // missions/create
    public function create() {
        if (Request::isMethod('get')) {

            // Just load the page if the request is not AJAX
            if (!Request::ajax()) {
                return View::make('missions.create');
            // Load the required data for the page if the request is AJAX
            } else {
                return Response::json(array(
                    'destinations' => Destination::all(['destination_id', 'destination'])->toArray(),
                    'missionTypes' => MissionType::all(['name', 'mission_type_id'])->toArray(),
                    'launchSites' => Location::where('type', 'Launch Site')->get()->toArray(),
                    'landingSites' => Location::where('type', 'Landing Site')->orWhere('type', 'ASDS')->get()->toArray(),
                    'vehicles' => Vehicle::all(['vehicle', 'vehicle_id'])->toArray(),
                    'spacecraftTypes' => array('Dragon 1', 'Dragon 2'),
                    'spacecraftReturnMethods' => array('Splashdown', 'Landing'),
                    'firstStageEngines' => array('Merlin 1A', 'Merlin 1B', 'Merlin 1C', 'Merlin 1D'),
                    'upperStageEngines' => array('Kestrel', 'Merlin 1C-Vac', 'Merlin 1D-Vac'),
                    'upperStageStatuses' => array('Did not reach orbit', 'Decayed', 'Deorbited', 'Earth Orbit', 'Solar Orbit'),
                    'parts' => Part::whereDoesntHave('partFlights', function($q) {
                        $q->where('landed', false);
                    })->get()->toArray(),
                    'spacecraft' => Spacecraft::all()->toArray(),
                    'astronauts' => Astronaut::all()->toArray()
                ));
            }

        } elseif (Request::isMethod('post')) {

            if ($this->missionCreator->isValid()) {
                // Create
                $mission = $this->missionCreator->create();

                // Email it out to those with the new Mission notification
                $this->missionQueuer->newMission($mission);

                // Add to RSS

                // Tweet about it

                return Redirect::route('missions.get', array('slug' => $mission->slug));
            } else {
                return Response::json(array(
                    'flashMessage' => array('contents' => 'The mission could not be created', 'type' => 'failure'),
                    'errors' => $this->missionCreator->getErrors()
                ), 400);
            }
        }
    }

    // AJAX GET
    // missions/all
    public function all() {
        $allMissions = Mission::with('featuredImage')->get();
        return Response::json($allMissions);
    }

    // AJAX POST
    // /missions/{slug}/requestlaunchdatetime
    public function requestLaunchDateTime($slug) {
        $mission = Mission::whereSlug($slug)->with('vehicle')->first();

        return Response::json(array('launchDateTime' => $mission->present()->launch_exact()));
    }

    // GET
    // /missions/{slug}/raw
    public function raw($slug) {
        $mission = Mission::whereSlug($slug)->first();

        $json = [
            'json_generated_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'mission_type' => $mission->missionType->name,
            'launch_date_time' => $mission->launch_date_time,
            'name' => $mission->name,
            'contractor' => $mission->contractor,
            'vehicle' => $mission->vehicle->vehicle,
            'destination' => $mission->destination->destination,
            'launch_site' => $mission->launchSite->fullLocation,
            'summary' => $mission->summary,
            'status' => $mission->status,
            'outcome' => $mission->outcome,
            'fairings_recovered' => $mission->fairings_recovered,
            'mission_created_at' => $mission->created_at->toDateTimeString()
        ];

        return Response::make(json_encode($json), 200, array(
            'Content-type' => 'application/json',
            'Content-Disposition' => 'attachment;filename="'.$slug.'.json"'
        ));
    }
}
 