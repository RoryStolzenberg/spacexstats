<?php
class EmailNotification extends Eloquent {

    protected $table = 'email_notifications';
    protected $primaryKey = 'email_notifications_id';
    public $timestamps = true;

    protected $hidden = [];
    protected $appends = [];
    protected $fillable = [];
    protected $guarded = [];

    // Relations
    public function emails() {
        return $this->hasMany('Email');
    }

    public function notificationType() {
        return $this->belongsTo('NotificationType');
    }

    public function user() {
        return $this->belongsTo('User');
    }
}
