<?php
namespace SpaceXStats\Http\Controllers\MissionControl;

use SpaceXStats\Http\Controllers\Controller;
use SpaceXStats\Models\Publisher;
use JavaScript;

class PublishersController extends Controller {

	public function __construct(Publisher $publisher) {
		$this->publisher = $publisher;
	}

    public function index() {
        JavaScript::put([
            'publishers' => Publisher::all()
        ]);

        return view('missionControl.publishers.index');
    }

	public function get($publisher_id) {
		return view('missionControl.publishers.get', [
			'publisher' => Publisher::find($publisher_id)
		]);
	}

	public function create() {
        if ($this->publisher->isValid(Input::get('publisher'))) {

            // Create publisher
            /*$publisher = Publisher::create(array(
                'name' =>
                'description' =>
            ));*/

            //return response()->json($publisher, 200);
        }
        return response()->json();
	}

	public function edit($publisher_id) {

        // Is the publisher details provided valid?
        if ($this->publisher->isValid(Input::get('publisher'))) {

            // update
            $publisher = Publisher::find(Input::get('publisher.publisher_id'));
            $publisher->name =
            $publisher->description =
            $publisher->save();

            // Edit publisher
            return response()->json(null, 204);
        }
        return response()->json();
	}
}