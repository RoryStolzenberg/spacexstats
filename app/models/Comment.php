<?php
class Comment extends Eloquent {
    protected $table = 'comments';
    protected $primaryKey = 'comment_id';
    public $timestamps = true;

    protected $hidden = [];
    protected $appends = [];
    protected $fillable = [];
    protected $guarded = [];

    // Relationships
    public function object() {
        return $this->belongsTo('Object');
    }

    public function user() {
        return $this->belongsTo('User');
    }
}
