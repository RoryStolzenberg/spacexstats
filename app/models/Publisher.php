<?php
namespace SpaceXStats\Models;

use Illuminate\Database\Eloquent\Model;
use SpaceXStats\Validators\ValidatableTrait;

class Publisher extends Model {

    use ValidatableTrait;

    protected $table = 'publishers';
    protected $primaryKey = 'publisher_id';
    public $timestamps = false;

    protected $hidden = [];
    protected $appends = [];
    protected $fillable = [];
    protected $guarded = [];

    // Validation
    public $rules = array(
        'name' => ['unique:publishers', 'varchar:tiny', 'required'],
        'description' => ['varchar:medium', 'required'],
        'url' => ['varchar:small', 'required']
    );

    public $messages = array();

    // Relations
    public function objects() {
        return $this->hasMany('SpaceXStats\Models\Object');
    }
}
