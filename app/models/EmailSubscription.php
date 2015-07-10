<?php
class EmailSubscription extends Eloquent {

    protected $table = 'email_subscriptions';
    protected $primaryKey = 'email_subscription_id';
    public $timestamps = true;

    protected $hidden = [];
    protected $appends = [];
    protected $fillable = [];
    protected $guarded = [];

    // Relations
    public function emails() {
        return $this->hasMany('Email');
    }

    public function subscriptionType() {
        return $this->belongsTo('SubscriptionType');
    }

    public function user() {
        return $this->belongsTo('User');
    }
}
