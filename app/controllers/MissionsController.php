<?php
use SpaceXStats\Services\MissionActionService;
use SpaceXStats\MailQueues\MissionMailQueue;
use SpaceXStats\Mailers\MissionNotificationsMailer;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class MissionsController extends BaseController {

    protected $missionCreator;

    public function __construct(MissionActionService $missionActioner, MissionMailQueue $missionQueuer) {
        $this->missionActioner = $missionActioner;
        $this->missionQueuer = $missionQueuer;
    }

	// GET 
	// /missions/{slug}
	public function get($slug) {

        $mission = Mission::whereSlug($slug)->first();

        $pastMission = Mission::pastMissions($mission->launch_order_id, 1)->first(['mission_id', 'slug', 'name']);
        $futureMission = Mission::futureMissions($mission->launch_order_id, 1)->first(['mission_id', 'slug', 'name']);

		if ($mission->status === 'Upcoming' || $mission->status === 'In Progress') {
            JavaScript::put([
                'slug' => $mission->slug,
                'launchDateTime' => $mission->present()->launchDateTime(DateTime::ISO8601),
                'launchSpecificity' => $mission->launch_specificity,
                'webcast' => Redis::hgetall('webcast')
            ]);

			return View::make('missions.futureMission', array(
				'mission' => $mission,
                'pastMission' => $pastMission,
                'futureMission' => $futureMission
			));			
		} else {
			return View::make('missions.pastMission', array(
				'mission' => $mission,
                'pastMission' => $pastMission,
                'futureMission' => $futureMission
			));	
		}
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

                    'vehicles' => Vehicle::get()->lists('vehicle', 'vehicle_id'),
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

            $input = Input::all();

            if ($this->missionActioner->isValid($input)) {
                // Create
                $mission = $this->missionActioner->create($input);

                // Email it out to those with the new Mission notification
                $this->missionQueuer->newMission($mission);

                // Add to RSS

                // Tweet about it

                return Redirect::route('missions.get', array('slug' => $mission->slug));
            } else {
                return Redirect::back()
                    ->with('flashMessage', array('contents' => 'The mission could not be created', 'type' => 'failure'))
                    ->withInput()
                    ->withErrors($this->missionCreator->getErrors());
            }

            // if successful

        }
    }

    // AJAX GET
    // missions/all
    public function all() {
        $allMissions = Mission::with('featuredImage')->get(['mission_id', 'name', 'featured_image']);
        return Response::json($allMissions);
    }

    /// AJAX POST
    // /missions/{slug}/requestlaunchdatetime
    public function requestLaunchDateTime($slug) {
        $mission = Mission::whereSlug($slug)->with('vehicle')->first();

        return Response::json(array('launchDateTime' => $mission->present()->launch_exact()));
    }
}
 