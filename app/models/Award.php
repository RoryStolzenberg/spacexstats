<?php
namespace SpaceXStats\Models;

use Illuminate\Database\Eloquent\Model;
use SpaceXStats\Library\Miscellaneous\DeltaV;

class Award extends Model {

    protected $table = 'awards';
    protected $primaryKey = 'award_id';
    public $timestamps = true;

    protected $hidden = [];
    protected $appends = [];
    protected $fillable = [];
    protected $guarded = [];

    // Relationships
    public function object() {
        return $this->belongsTo('SpaceXStats\Models\Object');
    }

    public function user() {
        return $this->belongsTo('SpaceXStats\Models\User');
    }

    // Attribute Accessors
}
