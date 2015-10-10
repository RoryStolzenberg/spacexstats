<?php
namespace App\Models;
class Message extends Model {

    protected $table = 'messages';
    protected $primaryKey = 'message_id';
    public $timestamps = true;

    protected $hidden = [];
    protected $appends = [];
    protected $fillable = [];
    protected $guarded = [];

    public function user() {
        return $this->belongsTo('User');
    }
}