<?php

class Statistic extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'statistics';
	protected $primaryKey = 'statistic_id';
	public $timestamps = false;
	protected $appends = array('result');

	// Attribute Accessors
	public function getResultAttribute() {
		$type = camel_case($this->type);

		if (!empty($this->name)) {
			return StatisticBuilder::$type($this->name);
		} else {
			return StatisticBuilder::$type();
		}
	}
}
