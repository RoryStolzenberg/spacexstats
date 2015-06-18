<?php

class CalendarDownload extends Eloquent {

	protected $table = 'calendar_downloads';
	protected $primaryKey = 'calendar_download_id';
    public $timestamps = true;

    protected $hidden = [];
    protected $appends = [];
    protected $fillable = [];
    protected $guarded = [];

	// Relations
}