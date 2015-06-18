<?php
class Uses extends Eloquent {
    protected $table = 'uses';
    protected $primaryKey = 'use_id';
    protected $timestamps = false;

    protected $hidden = [];
    protected $appends = [];
    protected $fillable = [];
    protected $guarded = [];

    // Relations
    public function mission() {
        return $this->belongsTo('Mission');
    }

    public function core() {
        return $this->belongsTo('Core');
    }

    public function landingSite() {
        return $this->belongsTo('LandingSite');
    }

    // Validation
    public function isValid($input) {
        $rules = array(
            'firststage_landing_legs' => 'boolean',
            'firststage_grid_fins' => 'boolean',
            'firststage_engine' => '',
            'firststage_landed' => 'boolean',
            'firststage_outcome' => '',
            'firststage_engine_failures' => 'integer|min:0|max:9',
            'firststage_meco' => '',
            'firststage_landing_coords_lat' => '',
            'firststage_landing_coords_lng' => ''
        );

        $validator = Validator::make($input, $rules);
        return $validator->passes() ? true : $validator->errors();
    }

}