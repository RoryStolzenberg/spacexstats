<?php
namespace SpaceXStats\Models;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model {

	protected $table = 'favorites';
	protected $primaryKey = 'favorite_id';
    public $timestamps = true;

    protected $hidden = [];
    protected $appends = [];
    protected $fillable = [];
    protected $guarded = [];

	// Relations
	public function user() {
		return $this->belongsTo('SpaceXStats\Models\User');
	}

	public function object() {
		return $this->belongsTo('SpaceXStats\Models\Object');
	}
}