<?php
namespace App\Models;
class Note extends Model {
    protected $table = 'notes';
    protected $primaryKey = 'note_id';
    public $timestamps = true;

    protected $hidden = [];
    protected $appends = [];
    protected $fillable = [];
    protected $guarded = [];

    // Relations
    public function users() {
        return $this->belongsTo('user');
    }

    public function object() {
        return $this->belongsTo('object');
    }
}