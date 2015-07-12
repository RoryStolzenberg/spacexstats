<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Notification extends Eloquent {

    use SoftDeletingTrait;

    protected $table = 'notifications';
    protected $primaryKey = 'notifications_id';
    public $timestamps = true;

    protected $hidden = [];
    protected $appends = [];
    protected $fillable = [];
    protected $guarded = [];

    // Relations
    public function emails() {
        return $this->hasMany('Email');
    }

    public function SMSes() {
        return $this->hasMany('SMS');
    }

    public function notificationType() {
        return $this->belongsTo('NotificationType');
    }

    public function user() {
        return $this->belongsTo('User');
    }
}
