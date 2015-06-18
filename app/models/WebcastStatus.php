<?php

class WebcastStatus extends Eloquent {

	protected $table = 'webcast_statuses';
	protected $primaryKey = 'webcast_status_id';
    protected $timestamps = true;

    protected $hidden = [];
    protected $appends = [];
    protected $fillable = ['viewers', 'created_at'];
    protected $guarded = [];

}