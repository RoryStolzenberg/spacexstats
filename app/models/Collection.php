<?php
namespace SpaceXStats\Models;
use Illuminate\Database\Eloquent\Model;
use SpaceXStats\Validators\ValidatableTrait;

class Collection extends Model {

    use ValidatableTrait;

    protected $table = 'collections';
    protected $primaryKey = 'collection_id';
    public $timestamps = true;

    protected $hidden = [];
    protected $appends = [];
    protected $fillable = [];
    protected $guarded = [];

    // Validation
    protected $rules = array(
        'title' => 'varchar:small',
        'summary' => 'varchar:large'
    );

    protected $messages = [];

    // Relationships
    public function objects() {
        return $this->belongsToMany('SpaceXStats\Models\Object', 'collections_objects_pivot');
    }

    public function tags() {
        return $this->morphToMany('SpaceXStats\Models\Tag', 'taggable', 'taggable_pivot');
    }
}
