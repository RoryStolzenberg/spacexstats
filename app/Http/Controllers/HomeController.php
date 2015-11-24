<?php
namespace SpaceXStats\Http\Controllers;

use JavaScript;
use SpaceXStats\Console\Commands\SpaceTrackDataFetchCommand;
use SpaceXStats\Models\Statistic;

class HomeController extends Controller {

	public function home()	{

        JavaScript::put([
            'statistics' => array_values(Statistic::orderBy('order')->get
            ()->groupBy('type')->toArray())
        ]);

		return view('home');
	}

}
 