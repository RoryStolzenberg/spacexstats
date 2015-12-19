<?php
namespace SpaceXStats\Models;
use Illuminate\Database\Eloquent\Model;

class LiveUpdate extends Model {

    protected $table = 'live_updates';
    protected $primaryKey = 'live_update_id';
    public $timestamps = false;

    protected $hidden = [];
    protected $appends = [];
    protected $fillable = [];
    protected $guarded = [];

    protected $dates = ['created_at', 'updated_at'];

    public function user() {
        return $this->belongsTo('SpaceXStats\Models\User');
    }
}