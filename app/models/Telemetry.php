<?php
class Telemetry extends Eloquent {
    protected $table = 'telemetries';
    protected $primaryKey = 'telemetry_id';
    public $timestamps = true;

    protected $hidden = [];
    protected $appends = [];
    protected $fillable = [];
    protected $guarded = [];

    // Relations
    public function mission() {
        return $this->belongsTo('Mission');
    }
}