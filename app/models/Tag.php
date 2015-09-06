<?php

class Tag extends Eloquent {
    protected $table = 'tags';
    protected $primaryKey = 'tag_id';
    public $timestamps = true;

    protected $hidden = [];
    protected $appends = [];
    protected $fillable = [];
    protected $guarded = [];

    protected $rules = array(
        'name' => 'required|string|varchar:tiny,unique:tags',
        'description' => 'string|varchar:compact'
    );

    public function isValid($input) {
        $validator = Validator::make($input, $this->rules);
        return $validator->passes() ? true : $validator->errors();
    }

    // Relations
    public function objects() {
        return $this->morphedByMany('Object', 'taggable', 'taggables_pivot');
    }

    public function collections() {
        return $this->morphedByMany('Collection', 'taggable', 'taggables_pivot');
    }
}
