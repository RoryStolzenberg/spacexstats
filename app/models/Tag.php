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
        'name' => 'required|string|varchar:small,unique:tags',
        'description' => 'string|varchar:medium'
    );

    public function isValid($input) {
        $validator = Validator::make($input, $this->rules);
        return $validator->passes() ? true : $validator->errors();
    }

    // Relations
    public function objects() {
        return $this->belongsToMany('Object', 'objects_tags_pivot');
    }
}
