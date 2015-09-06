<?php

class Collection extends Eloquent {
    protected $table = 'collections';
    protected $primaryKey = 'collection_id';
    public $timestamps = true;

    protected $hidden = [];
    protected $appends = [];
    protected $fillable = [];
    protected $guarded = [];

    // Relationships
    public function objects() {
        return $this->belongsToMany('Objects', 'collections_objects_pivot');
    }

    public function tags() {
        return $this->morphToMany('Tag', 'taggable', 'taggable_pivot');
    }
}
