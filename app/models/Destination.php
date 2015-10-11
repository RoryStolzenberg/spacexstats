<?php
namespace SpaceXStats\Models;

use Illuminate\Database\Eloquent\Model;

class Destination extends Model {
    protected $table = 'destinations';
    protected $primaryKey = 'destination_id';
    public $timestamps = false;

    protected $hidden = [];
    protected $appends = [];
    protected $fillable = [];
    protected $guarded = [];

    // Relationships
    public function missions() {
        return $this->hasOneOrMany('SpaceXStats\Model\Mission');
    }
}