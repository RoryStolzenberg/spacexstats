<?php
class DataView extends Eloquent {
    
    protected $table = 'dataviews';
    protected $primaryKey = 'dataview_id';
    public $timestamps = false;

    protected $hidden = [];
    protected $appends = ['data'];
    protected $fillable = [];
    protected $guarded = [];

    // Relations
    public function bannerImage() {
        return $this->hasOne('Object', 'banner_image');
    }

    public function getDataAttribute() {
    }
}