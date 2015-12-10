<?php
namespace SpaceXStats\Models;

use Illuminate\Database\Eloquent\Model;
use Validator;

class Tag extends Model {
    protected $table = 'tags';
    protected $primaryKey = 'tag_id';
    public $timestamps = true;

    protected $hidden = [];
    protected $appends = [];
    protected $fillable = [];
    protected $guarded = [];

    protected $rules = [
        'name' => ['required', 'string', 'varchar:tiny', 'unique:tags', "regex:/[a-z0-9-]+/"],
        'description' => ['string', 'varchar:compact']
    ];

    public function isValid($input) {
        $validator = Validator::make($input, $this->rules);
        return $validator->passes() ? true : $validator->errors();
    }

    // Relations
    public function objects() {
        return $this->morphedByMany('SpaceXStats\Models\Object', 'taggable', 'taggables_pivot');
    }

    public function collections() {
        return $this->morphedByMany('SpaceXStats\Models\Collection', 'taggable', 'taggables_pivot');
    }
}
