<?php
namespace SpaceXStats\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes as SoftDeletingTrait;

class Notification extends Model {

    use SoftDeletingTrait;

    protected $table = 'notifications';
    protected $primaryKey = 'notification_id';
    public $timestamps = true;

    protected $hidden = [];
    protected $appends = [];
    protected $fillable = [];
    protected $guarded = [];

    // Relations
    public function emails() {
        return $this->hasMany('SpaceXStats\Models\Email');
    }

    public function SMSes() {
        return $this->hasMany('SpaceXStats\Models\SMS');
    }

    public function notificationType() {
        return $this->belongsTo('SpaceXStats\Models\NotificationType');
    }

    public function user() {
        return $this->belongsTo('SpaceXStats\Models\User');
    }
}
