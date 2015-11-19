<?php 
namespace SpaceXStats\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Redis;
use JavaScript;
use SpaceXStats\Http\Requests\CreateMissionRequest;
use SpaceXStats\Http\Requests\EditMissionRequest;
use SpaceXStats\Library\Enums\MissionControlType;
use SpaceXStats\Library\Enums\MissionStatus;
use SpaceXStats\Library\Enums\MissionControlSubtype;
use SpaceXStats\ModelManagers\MissionManager;
use SpaceXStats\Models\Astronaut;
use SpaceXStats\Models\Destination;
use SpaceXStats\Models\Location;
use SpaceXStats\Models\Mission;
use SpaceXStats\Models\MissionType;
use SpaceXStats\Models\Object;
use SpaceXStats\Models\Part;
use SpaceXStats\Models\Spacecraft;
use SpaceXStats\Models\Vehicle;

class MissionsController extends Controller {

    /**
     * GET (HTTP), /missions/{slug}. Where slug is a slugged name of the Mission.
     *
     * @param $slug
     * @return \Illuminate\View\View
     */
    public function get($slug) {

        $mission = Mission::with(['telemetries', 'orbitalElements'])->whereSlug($slug)->first();

        $pastMission = Mission::previous($mission->launch_order_id, 1)->first(['mission_id', 'slug', 'name']);
        $futureMission = Mission::next($mission->launch_order_id, 1)->first(['mission_id', 'slug', 'name']);

        $data = array(
            'mission' => $mission,
            'pastMission' => $pastMission,
            'futureMission' => $futureMission
        );

		if ($mission->status === MissionStatus::Upcoming || $mission->status === MissionStatus::InProgress) {

            JavaScript::put([
                'mission' => $mission,
                'webcast' => Redis::hgetall('webcast')
            ]);

			return view('missions.futureMission', $data);
		} else {

            $js['mission'] = $mission;

            if (Auth::isSubscriber()) {
                $js['telemetry'] = $mission->telemetries->orderBy('timestamp', 'ASC')->get()->filter(function($telemetry) {
                    return $telemetry->hasPositionalData();
                })->values();
                $js['orbitalElements'] = $mission->orbitalElements->sortBy('epoch');
            }

            JavaScript::put($js);

            $data['documents'] = Object::inMissionControl()->authedVisibility()->where('type', MissionControlType::Document)->orderBy('created_at')->get();
            $data['images'] = Object::inMissionControl()->wherePublic()->where('type', MissionControlType::Image)->orderBy('created_at')->get();
            $data['launchVideo'] = $mission->launchVideo();
            $data['orbitalElements'] = $mission->orbitalElements->sortBy('epoch');

            return view('missions.pastMission', $data);
        }
	}

    /**
     * GET, /missions/future. Shows all future missions in a list.
     *
     * @return \Illuminate\View\View
     */
    public function future() {

        JavaScript::put([
            'missions' => Mission::future()->with('vehicle')->get()
        ]);

		return view('missions.future');
	}

    /**
     * GET, /missions/past. Shows all past missions in a list.
     *
     * @return \Illuminate\View\View
     */
    public function past() {

        JavaScript::put([
            'missions' => Mission::past(true)->with('vehicle')->get()
        ]);

		return view('missions.past');
	}

    /**
     * GET POST, /missions/{slug}/edit. Edit a mission.
     *
     * @param $slug
     * @return \Illuminate\View\View
     */
    public function getEdit($slug) {

        // Fetch all objects at once and then organize into collection to reduce queries
        $missionObjects = Object::wherePublic()->inMissionControl()->whereHas('mission', function($q) use($slug) {
            $q->whereSlug($slug);
        })->get();

        JavaScript::put([
            'mission'           => Mission::whereSlug($slug)
                ->with('payloads', 'spacecraftFlight.spacecraft', 'spacecraftFlight.astronautFlights.astronaut', 'partFlights.part', 'prelaunchEvents', 'telemetries')->first(),
            'destinations'      => Destination::all(['destination_id', 'destination'])->toArray(),
            'missionTypes'      => MissionType::all(['name', 'mission_type_id'])->toArray(),
            'launchSites'       => Location::where('type', 'Launch Site')->get()->toArray(),
            'landingSites'      => Location::where('type', 'Landing Site')->orWhere('type', 'ASDS')->get()->toArray(),
            'vehicles'          => Vehicle::all(['vehicle', 'vehicle_id'])->toArray(),
            'parts'             => Part::whereDoesntHave('partFlights', function($q) {
                                        $q->where('landed', false);
                                    })->get()->toArray(),
            'spacecraft'        => Spacecraft::all()->toArray(),
            'astronauts'        => Astronaut::all()->toArray(),
            'launchVideos'      => $missionObjects->where('subtype', MissionControlSubtype::LaunchVideo)->filter(function($item) {
                                        return $item->external_url != null;
                                    })->values(),
            'featuredImages'    => $missionObjects->where('subtype', MissionControlSubtype::Photo)->values(),
            'missionPatches'    => $missionObjects->where('subtype', MissionControlSubtype::MissionPatch)->values(),
            'pressKits'         => $missionObjects->where('subtype', MissionControlSubtype::PressKit)->values(),
            'cargoManifests'    => $missionObjects->where('subtype', MissionControlSubtype::CargoManifest)->values(),
            'pressConferences'  => $missionObjects->where('subtype', MissionControlSubtype::PressConference)->filter(function($item) {
                                        return $item->external_url != null;
                                    })->values()
        ]);

        return view('missions.edit');
    }

    public function patchEdit(MissionManager $missionManager) {
        if ($missionManager->isValid()) {
            $mission = $missionManager->update();

            // Return, frontend to redirect.
            return response()->json($mission->slug);

        } else {
            return response()->json(array(
                'flashMessage' => 'The mission could not be saved',
                'errors' => $missionManager->getErrors()
            ), 400);
        }
    }

    public function getCreate() {
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

        return view('missions.create');
    }

    public function postCreate(MissionManager $missionManager) {
        if ($missionManager->isValid()) {
            $mission = $missionManager->create();

            // Return, frontend to redirect to newly created page.
            return response()->json($mission->slug);
        } else {
            return response()->json(array(
                'flashMessage' => 'The mission could not be created',
                'errors' => $missionManager->getErrors()
            ), 400);
        }
    }

    // AJAX GET
    // missions/all
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function all() {
        $allMissions = Mission::with('featuredImage')->get();
        return response()->json($allMissions);
    }

    /**
     * GET (AJAX), /missions/{slug}/launchdatetime. Get the launch datetime of the current mission.
     *
     * @param $slug
     * @return \Illuminate\Http\JsonResponse
     */
    public function launchDateTime($slug) {
        $mission = Mission::whereSlug($slug)->with('vehicle')->first();

        return response()->json(array('launchDateTime' => $mission->present()->launch_exact()));
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

        return response()->json($telemetries);
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
 