<?php

class StatisticPresenter {

	public static function format($statistics) {
		$orderedStatistics = [];

		$statistics->each(function($var) use(&$orderedStatistics) {
				$orderedStatistics[$var->type][] = $var->toArray();
		});

		return $orderedStatistics;
	}
}

?>