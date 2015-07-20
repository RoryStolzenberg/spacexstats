<?php
class Payload extends Eloquent {

    use ValidatableTrait;

    protected $table = 'payloads';
    protected $primaryKey = 'payload_id';
    public $timestamps = true;

    protected $hidden = [];
    protected $appends = [];
    protected $fillable = [];
    protected $guarded = [];

    // Validation
    public $rules = array(
        'mission_id'    => ['required', 'exists:missions,mission_id'],
        'name'          => ['required', 'varchar:small'],
        'operator'      => ['required', 'varchar:compact'],
        'mass'          => ['min:0', 'numeric', 'digits_between:0,5'],
        'primary'       => ['boolean'],
        'link'          => ['varchar:compact']
    );

    public $messages = array();

    // Relations
    public function mission() {
        return $this->belongsTo('Mission');
    }
}