<?php

class Tag extends Eloquent {
    protected $table = 'tags';
    protected $primaryKey = 'tag_id';
    public $timestamps = true;

    // Relations
    public function missions() {
        return $this->hasMany('Mission');
    }
}
