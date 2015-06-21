<?php

class HomeController extends BaseController {

	public function home()	{
		return View::make('home', array(
			'statistics' => StatisticPresenter::format(Statistic::orderBy('order')->get()),
			'currentPage' => 'home'
		));
	}

}
 