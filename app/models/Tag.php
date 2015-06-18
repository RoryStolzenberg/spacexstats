<?php

class Tag extends Eloquent {
    protected $table = 'tags';
    protected $primaryKey = 'tag_id';
    protected $timestamps = true;

    protected $hidden = [];
    protected $appends = [];
    protected $fillable = [];
    protected $guarded = [];

    // Relations
    public function missions() {
        return $this->hasMany('Mission');
    }
}
