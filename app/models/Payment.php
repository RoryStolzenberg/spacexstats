<?php
namespace SpaceXStats\Models;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model {
    protected $table = 'payments';
    protected $primaryKey = 'payment_id';
    public $timestamps = true;

    protected $hidden = [];
    protected $appends = [];
    protected $fillable = [];
    protected $guarded = [];

    // Relationships
    public function user() {
        return $this->hasOne('SpaceXStats\Models\User');
    }
}