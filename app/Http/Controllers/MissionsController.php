<?php 
 namespace SpaceXStats\Http\Controllers;
use SpaceXStats\Managers\MissionManager;
use SpaceXStats\Enums\MissionControlSubtype;

class MissionsController extends Controller {

    protected $missionManager;

    public function __construct(MissionManager $missionManager) {
        $this->missionManager = $missionManager;
    }

    /**
     * GET, /missions/{slug}. Where slug is a slugged name of the Mission.
     *
     * @param $slug
     * @return \Illuminate\View\View
     */
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
                'mission' => $mission,
                'webcast' => Redis::hgetall('webcast')
            ]);
			return View::make('missions.futureMission', $data);
		} else {

            $js['mission'] = $mission;

            if (Auth::isSubscriber()) {
                $js['telemetry'] = $mission->telemetries()->orderBy('timestamp', 'ASC')->get();
            }

            JavaScript::put($js);
            return View::make('missions.pastMission', $data);
        }
	}

    /**
     * GET, /missions/future. Shows all future missions in a list.
     *
     * @return \Illuminate\View\View
     */
    public function future() {
        $futureMissions = Mission::where('status','=','Upcoming')
                                    ->orWhere('status','In Progress')
									->orderBy('launch_order_id')
									->with('vehicle')->get();

        JavaScript::put([
            'missions' => $futureMissions
        ]);

		return View::make('missions.future');
	}

    /**
     * GET, /missions/past. Shows all past missions in a list.
     *
     * @return \Illuminate\View\View
     */
    public function past() {
		$pastMissions = Mission::where('status','=','Complete')
                                    ->orWhere('status','=','In Progress')
                                    ->orderBy('launch_order_id', 'DESC')
									->with('vehicle')->get();

        JavaScript::put([
            'missions' => $pastMissions
        ]);

		return View::make('missions.past');
	}

    /**
     * GET POST, /missions/{slug}/edit. Edit a mission.
     *
     * @param $slug
     * @return \Illuminate\View\View
     */
    public function edit($slug) {
        if (Request::isMethod('get')) {

            JavaScript::put([
                'mission' => Mission::whereSlug($slug)
                    ->with('payloads', 'spacecraftFlight.spacecraft', 'spacecraftFlight.astronautFlights.astronaut', 'partFlights.part', 'prelaunchEvents', 'telemetries')->first(),
                'destinations' => Destination::all(['destination_id', 'destination'])->toArray(),
                'missionTypes' => MissionType::all(['name', 'mission_type_id'])->toArray(),
                'launchSites' => Location::where('type', 'Launch Site')->get()->toArray(),
                'landingSites' => Location::where('type', 'Landing Site')->orWhere('type', 'ASDS')->get()->toArray(),
                'vehicles' => Vehicle::all(['vehicle', 'vehicle_id'])->toArray(),
                'parts' => Part::whereDoesntHave('partFlights', function($q) {
                    $q->where('landed', false);
                })->get()->toArray(),
                'spacecraft' => Spacecraft::all()->toArray(),
                'astronauts' => Astronaut::all()->toArray(),
                'launchVideos' => Object::where('subtype', MissionControlSubtype::LaunchVideo)->whereNotNull('external_url')->whereHas('mission', function($q) use ($slug) {
                    $q->whereSlug($slug);
                })->get(),
                'missionPatches' => Object::where('subtype', MissionControlSubtype::MissionPatch)->whereHas('mission', function($q) use ($slug) {
                    $q->whereSlug($slug);
                })->get(),
                'pressKits' => Object::where('subtype', MissionControlSubtype::PressKit)->whereHas('mission', function($q) use ($slug) {
                    $q->whereSlug($slug);
                })->get(),
                'cargoManifests' => Object::where('subtype', MissionControlSubtype::CargoManifest)->whereHas('mission', function($q) use ($slug) {
                    $q->whereSlug($slug);
                })->get(),
                'pressConferences' => Object::where('subtype', MissionControlSubtype::PressConference)->whereHas('mission', function($q) use ($slug) {
                    $q->whereSlug($slug);
                })->get(),
                'featuredImages' => Object::where('subtype', MissionControlSubtype::Photo)->whereHas('mission', function($q) use ($slug) {
                    $q->whereSlug($slug);
                })->get(),
            ]);

            return View::make('missions.edit');

        } elseif (Request::isMethod('patch')) {

            if ($this->missionManager->isValid()) {
                $mission = $this->missionManager->update();

                // Return, frontend to redirect.
                return Response::json(['slug' => $mission->slug]);

            } else {
                return Response::json(array(
                    'flashMessage' => array('contents' => 'The mission could not be saved', 'type' => 'failure'),
                    'errors' => $this->missionManager->getErrors()
                ), 400);
            }
        }
    }

    // GET
    // missions/create
    /**
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function create() {
        if (Request::isMethod('get')) {

            JavaScript::put([
                'destinations' => Destination::all(['destination_id', 'destination'])->toArray(),
                'missionTypes' => MissionType::all(['name', 'mission_type_id'])->toArray(),
                'launchSites' => Location::where('type', 'Launch Site')->get()->toArray(),
                'landingSites' => Location::where('type', 'Landing Site')->orWhere('type', 'ASDS')->get()->toArray(),
                'vehicles' => Vehicle::all(['vehicle', 'vehicle_id'])->toArray(),
                'parts' => Part::whereDoesntHave('partFlights', function($q) {
                    $q->where('landed', false);
                })->get()->toArray(),
                'spacecraft' => Spacecraft::all()->toArray(),
                'astronauts' => Astronaut::all()->toArray()
            ]);

            return View::make('missions.create');

        } elseif (Request::isMethod('post')) {

            if ($this->missionManager->isValid()) {
                $mission = $this->missionManager->create();

                // Return, frontend to redirect to newly created page.
                return Response::json(['slug' => $mission->slug]);
            } else {
                return Response::json(array(
                    'flashMessage' => array('contents' => 'The mission could not be created', 'type' => 'failure'),
                    'errors' => $this->missionManager->getErrors()
                ), 400);
            }
        }
    }

    // AJAX GET
    // missions/all
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function all() {
        $allMissions = Mission::with('featuredImage')->get();
        return Response::json($allMissions);
    }

    /**
     * GET (AJAX), /missions/{slug}/launchdatetime. Get the launch datetime of the current mission.
     *
     * @param $slug
     * @return \Illuminate\Http\JsonResponse
     */
    public function launchDateTime($slug) {
        $mission = Mission::whereSlug($slug)->with('vehicle')->first();

        return Response::json(array('launchDateTime' => $mission->present()->launch_exact()));
    }

    /**
     * GET (AJAX), /missions/{$slug}/telemetry. Fetches all mission telemetries for a specified mission,
     * ordered by the telemetry timestamp.
     *
     * @param $slug
     * @return \Illuminate\Http\JsonResponse
     */
    public function telemetry($slug) {
        $telemetries = Telemetry::whereHas('mission', function($q) use ($slug) {
            $q->whereSlug($slug);
        })->orderBy('timestamp', 'ASC')->get();

        return Response::json($telemetries);
    }

    /**
     * GET, /missions/{slug}/raw. Get raw mission data, used for a raw data download on a mission page.
     *
     * @param $slug
     * @return \Illuminate\Http\Response
     */
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
 