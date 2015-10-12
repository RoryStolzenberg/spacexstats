<?php
namespace SpaceXStats\Models;

use Illuminate\Database\Eloquent\Model;
use SpaceXStats\Validators\ValidatableTrait;

class Payload extends Model {

    use ValidatableTrait;

    protected $table = 'payloads';
    protected $primaryKey = 'payload_id';
    public $timestamps = true;

    protected $hidden = [];
    protected $appends = [];
    protected $fillable = [];
    protected $guarded = [];

    // Validation
    public $rules = array(
        'mission_id'    => ['integer', 'exists:missions,mission_id'],
        'name'          => ['required', 'varchar:tiny'],
        'operator'      => ['required', 'varchar:small'],
        'mass'          => ['min:0', 'numeric'],
        'primary'       => ['boolean'],
        'link'          => ['varchar:small']
    );

    public $messages = array();

    // Relations
    public function mission() {
        return $this->belongsTo('SpaceXStats\Models\Mission');
    }
}