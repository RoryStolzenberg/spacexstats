<?php
namespace SpaceXStats\Models;

use Illuminate\Database\Eloquent\Model;
use SpaceXStats\Validators\ValidatableTrait;

class Spacecraft extends Model {

    use ValidatableTrait;

	protected $table = 'spacecraft';
	protected $primaryKey = 'spacecraft_id';
    public $timestamps = false;

    protected $hidden = [];
    protected $appends = [];
    protected $fillable = [];
    protected $guarded = [];

    // Validation
    public $rules = array(
        'name'  => ['required', 'varchar:tiny'],
        'type'  => ['required']
    );

    public $messages = array();

    // Relations
    public function spacecraftFlights() {
        return $this->hasMany('SpaceXStats\Models\SpacecraftFlight');
    }

	public function missions() {
		return $this->hasManyThrough('SpaceXStats\Models\Mission', 'SpacecraftFlights');
	}

	// Attribute Accessors
}
