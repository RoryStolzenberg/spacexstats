<?php

class Tag extends Eloquent {
    protected $table = 'tags';
    protected $primaryKey = 'tag_id';
    public $timestamps = true;

    protected $hidden = [];
    protected $appends = [];
    protected $fillable = [];
    protected $guarded = [];

    // Relations
    public function objects() {
        return $this->belongsToMany('Object', 'object_tags', 'object_id', 'tag_id');
    }
}
