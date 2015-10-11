<?php
namespace SpaceXStats\Models;
use Illuminate\Database\Eloquent\Model;

class CalendarDownload extends Model {

	protected $table = 'calendar_downloads';
	protected $primaryKey = 'calendar_download_id';
    public $timestamps = true;

    protected $hidden = [];
    protected $appends = [];
    protected $fillable = [];
    protected $guarded = [];

	// Relations
}