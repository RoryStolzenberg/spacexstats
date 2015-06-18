<?php

class Core extends Eloquent {
    protected $table = 'cores';
    protected $primaryKey = 'core_id';
    public $timestamps = true;

    protected $hidden = [];
    protected $appends = [];
    protected $fillable = [];
    protected $guarded = [];

    public function missions() {
        return $this->belongsToMany('Mission', 'uses');
    }

    public function uses() {
        return $this->hasOneOrMany('Uses');
    }
}