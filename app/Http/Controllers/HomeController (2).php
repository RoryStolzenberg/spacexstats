<?php
 namespace AppHttpControllers;

class HomeController extends Controller {

	public function home()	{

        JavaScript::put([
            'statistics' => array_values(Statistic::orderBy('order')->get
            ()->groupBy('type')->toArray())
        ]);

		return View::make('home');
	}

}
 