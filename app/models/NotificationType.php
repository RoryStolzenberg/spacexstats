<?php
class NotificationType extends Eloquent {
    protected $table = 'notification_types';
    protected $primaryKey = 'notification_type_id';
    public $timestamps = false;

    protected $hidden = [];
    protected $appends = [];
    protected $fillable = [];
    protected $guarded = ['*'];

    public function emailNotifications() {
        return $this->hasMany('EmailNotification');
    }
}