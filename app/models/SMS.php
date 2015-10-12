<?php
namespace SpaceXStats\Models;
use Illuminate\Database\Eloquent\Model;
class SMS extends Model {
    protected $table = 'smses';
    protected $primaryKey = 'sms_id';
    public $timestamps = true;

    protected $hidden = [];
    protected $appends = [];
    protected $fillable = [];
    protected $guarded = [];

    // Relations
    public function notification() {
        return $this->belongsTo('SpaceXStats\Models\Notification');
    }
}