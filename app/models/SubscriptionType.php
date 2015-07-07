<?php
class SubscriptionType extends Eloquent {
    protected $table = 'subscription_types';
    protected $primaryKey = 'subscription_type_id';
    public $timestamps = false;

    protected $hidden = [];
    protected $appends = [];
    protected $fillable = [];
    protected $guarded = ['*'];
}