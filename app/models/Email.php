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
}