<?php
namespace SpaceXStats\Models;
use Illuminate\Database\Eloquent\Model;
use SpaceXStats\Presenters\CollectionPresenter;
use SpaceXStats\Presenters\Traits\PresentableTrait;
use SpaceXStats\Validators\ValidatableTrait;
use SpaceXStats\Search\Traits\SearchableTrait as Searchable;

class Collection extends Model {

    use ValidatableTrait, PresentableTrait, Searchable;

    protected $table = 'collections';
    protected $primaryKey = 'collection_id';
    public $timestamps = true;

    protected $hidden = [];
    protected $appends = [];
    protected $fillable = [];
    protected $guarded = [];

    protected $presenter = CollectionPresenter::class;

    // Validation
    protected $rules = array(
        'title' => ['min:10', 'varchar:small'],
        'summary' => ['min:100', 'varchar:large']
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
