<?php
namespace SpaceXStats\Models;
use Illuminate\Database\Eloquent\Model;

class Collection extends Model {
    protected $table = 'collections';
    protected $primaryKey = 'collection_id';
    public $timestamps = true;

    protected $hidden = [];
    protected $appends = [];
    protected $fillable = [];
    protected $guarded = [];

    // Relationships
    public function objects() {
        return $this->belongsToMany('SpaceXStats\Models\Objects', 'collections_objects_pivot');
    }

    public function tags() {
        return $this->morphToMany('SpaceXStats\Models\Tag', 'taggable', 'taggable_pivot');
    }
}
