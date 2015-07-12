<?php

class WebcastStatus extends Eloquent {

	protected $table = 'webcast_statuses';
	protected $primaryKey = 'webcast_status_id';
    public $timestamps = true;

    protected $hidden = [];
    protected $appends = [];
    protected $fillable = [];
    protected $guarded = [];

}