<?php
namespace SpaceXStats\Models;
use Illuminate\Database\Eloquent\Model;
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
        return $this->belongsTo('SpaceXStats\Models\User');
    }

    public function object() {
        return $this->belongsTo('SpaceXStats\Models\Object');
    }
}