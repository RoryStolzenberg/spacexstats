<?php
class Email extends Eloquent {
    protected $table = 'emails';
    protected $primaryKey = 'email_id';
    public $timestamps = true;

    protected $hidden = [];
    protected $appends = [];
    protected $fillable = [];
    protected $guarded = [];

    public function getDates() {
        return ['created_at', 'updated_at', 'sent_at'];
    }

    // Relations
    public function notification() {
        return $this->belongsTo('Notification');
    }

    // Attribute Mutators
    public function setContentAttribute($value) {
        $this->attributes['content'] = $this->attributes['content']  . $value;
    }
}