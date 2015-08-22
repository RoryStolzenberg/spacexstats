<?php

class HomeController extends BaseController {

	public function home()	{

        JavaScript::put([
            'statistics' => array_values(Statistic::orderBy('order')->get
            ()->groupBy('type')->toArray())
        ]);

		return View::make('home');
	}

}
 