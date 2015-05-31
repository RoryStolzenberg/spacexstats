<?php

class WebcastStatus extends Eloquent {

	protected $table = 'webcast_statuses';
	protected $primaryKey = 'webcast_status_id';
	public $timestamps = false;

	protected $fillable = ['viewers', 'created_at'];

}