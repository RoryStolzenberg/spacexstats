<?php
namespace SpaceXStats\Models;

use Illuminate\Database\Eloquent\Model;

class Search extends Model {

    protected $table = 'searches';
    protected $primaryKey = 'search_id';
    public $timestamps = true;

    protected $hidden = [];
    protected $appends = [];
    protected $fillable = [];
    protected $guarded = [];

    // Relationships
    public function user() {
        return $this->belongsTo('SpaceXStats\Models\User');
    }
}
