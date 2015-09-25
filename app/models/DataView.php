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

    public function getColumnTitlesAttribute() {
        return json_decode($this->column_titles);
    }

    public function setColumnTitlesAttribute($value) {
        $this->attributes['column_titles'] = json_encode($value);
    }
}