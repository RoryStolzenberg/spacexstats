<?php

class StatisticPresenter {

	public static function format($statistics) {
		$orderedStatistics = [];

		$statistics->each(function($statistic) use(&$orderedStatistics) {
				$orderedStatistics[$statistic->type][] = $statistic->toArray();
		});

		return $orderedStatistics;
	}
}