<?php
use SpaceXStats\Services\MissionCreatorService;
use SpaceXStats\Mailers\MissionNotificationsMailer;

class MissionsController extends BaseController {

    protected $missionCreator;

    public function __construct(MissionCreatorService $missionCreator, MissionNotificationsMailer $missionMailer) {
        $this->missionCreator = $missionCreator;
        $this->missionMailer = $missionMailer;
    }

	// GET 
	// /missions/{slug}
	public function get($slug) {
		$mission = Mission::whereSlug($slug)->with('vehicle')->first();

		if ($mission->status === 'Upcoming' || $mission->status === 'In Progress') {
			return View::make('missions.futureMission', array(
				'title' => $mission->name . ' Mission',
				'currentPage' => 'mission',
				'mission' => $mission
			));			
		} else {
			return View::make('missions.pastMission', array(
				'title' => $mission->name . ' Mission',
				'currentPage' => 'mission',
				'mission' => $mission
			));	
		}
	}

	/// AJAX POST 
	// /missions/{slug}/requestlaunchdatetime
	public function requestLaunchDateTime($slug) {
		$mission = Mission::whereSlug($slug)->with('vehicle')->first();

		return Response::json(array('launchDateTime' => $mission->present()->launch_exact()));
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
			'title' => 'Future Launches',
			'currentPage' => 'future',
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
			'title' => 'Past Launches',
			'currentPage' => 'past',
			'futureLaunches' => $pastLaunches
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

            return View::make('missions.create', array(
                'destinations' => Destination::lists('destination', 'destination_id'),
                'missionTypes' => array('Dragon (ISS)' => 'Dragon (ISS)',
                                    'Dragon (Freeflight)' => 'Dragon (Freeflight)',
                                    'Communications Satellite' => 'Communications Satellite',
                                    'Constellation Mission' => 'Constellation Mission',
                                    'Military' => 'Military',
                                    'Scientific' => 'Scientific'),
                'launchSites' => LaunchSite::get()->lists('fullLocation', 'launch_site_id'),
                'landingSites' => LandingSite::get()->lists('fullLocation', 'landing_site_id'),
                'vehicles' => Vehicle::get()->lists('vehicle', 'vehicle_id'),
                'spacecraft' => array('Dragon 1', 'Dragon 2'),
                'spacecraftReturnMethods' => array('Splashdown', 'Landing'),
                'firstStageEngines' => array('Merlin 1A', 'Merlin 1B', 'Merlin 1C', 'Merlin 1D'),
                'upperStageEngines' => array('Kestrel', 'Merlin 1C-Vac', 'Merlin 1D-Vac')
            ));

        } elseif (Request::isMethod('post')) {

            $input = Input::all();

            if ($this->missionCreator->isValid($input)) {
                // Create
                $this->missionCreator->make($input);

                // Email it out
                $this->missionMailer->newMission();

                // Add to RSS

                // Tweet about it
                return Redirect::route('missions.get', array('slug' => 'test'));
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
        $allMissions = Mission::with('featuredImage')->get();
        return Response::json($allMissions);
    }
}
 