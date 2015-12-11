<?php
namespace SpaceXStats\Http\Controllers\MissionControl;

use Illuminate\Support\Facades\Input;
use SpaceXStats\Http\Controllers\Controller;
use SpaceXStats\Library\Enums\MissionControlType;
use SpaceXStats\Models\Object;
use SpaceXStats\Models\Publisher;
use JavaScript;

class PublishersController extends Controller {

	public function __construct(Publisher $publisher) {
		$this->publisher = $publisher;
	}

    public function index() {
        $publishers = Publisher::with('objects')->get()->map(function($publisher) {
            $publisher->articleCount = $publisher->objects->count();
            $publisher->mostRecentArticle = $publisher->objects->sortByDesc('originated_at')->first();
            unset($publisher->objects);
            return $publisher;
        });

        JavaScript::put([
            'publishers' => $publishers,
            'articleCount' => Object::where('type', MissionControlType::Article)->inMissionControl()->count()
        ]);

        return view('missionControl.publishers.index');
    }

	public function get($publisher_id) {
		return view('missionControl.publishers.get', [
			'publisher' => Publisher::find($publisher_id)
		]);
	}

	public function create() {
        if ($this->publisher->isValid(Input::get('publisher')) === true) {

            // Create publisher
            $publisher = Publisher::create([
                'name' => Input::get('publisher.name'),
                'description' => Input::get('publisher.description'),
                'url' => Input::get('publisher.url')
            ]);

            // Fetch and save their icon
            $publisher->saveFavicon();

            return response()->json($publisher, 200);
        }
        return response()->json(null, 422);
	}

	public function edit($publisher_id) {

        // Is the publisher details provided valid?
        if ($this->publisher->isValid(Input::get('publisher')) === true) {

            // update
            $publisher = Publisher::find(Input::get('publisher.publisher_id'));
            $publisher->name = Input::get('publisher.name');
            $publisher->description = Input::get('publisher.description');
            $publisher->save();

            // Edit publisher
            return response()->json(null, 204);
        }
        return response()->json(null, 422);
	}

    public function delete($publisher_id) {
        Publisher::find($publisher_id)->delete();
        return response()->json(null, 204);
    }
}