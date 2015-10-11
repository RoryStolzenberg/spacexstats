<?php
namespace SpaceXStats\Models;

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
        return $this->hasOneOrMany('SpacecraftFlights');
    }

	public function missions() {
		return $this->hasManyThrough('Mission', 'SpacecraftFlights');
	}

	// Attribute Accessors
}
