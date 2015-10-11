<?php
namespace SpaceXStats\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model {

    use ValidatableTrait, SoftDeletingTrait;

    protected $table = 'comments';
    protected $primaryKey = 'comment_id';
    public $timestamps = true;

    protected $hidden = [];
    protected $appends = ['ownership'];
    protected $fillable = [];
    protected $guarded = [];

    // Validation
    public $rules = array(
        'user_id'          => ['exists:users,user_id'],
        'object_id'        => ['exists:objects,object_id'],
        'comment'          => ['min:10', 'varchar:large'],
        'parent'           => ['exists:comments,comment_id']
    );

    public $messages = array();

    // Relationships
    public function object() {
        return $this->belongsTo('Object');
    }

    public function user() {
        return $this->belongsTo('User')->select(array('user_id', 'username'));
    }

    // Attribute Accessors
    public function getCommentAttribute() {
        if ($this->isHidden || $this->trashed()) {
            return null;
        }
        return $this->attributes['comment'];
    }

    public function getOwnershipAttribute() {
        return Auth::user()->user_id == $this->attributes['user_id'];
    }
}
