<?php
namespace SpaceXStats\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes as SoftDeletingTrait;
use Illuminate\Support\Facades\Auth;
use SpaceXStats\Validators\ValidatableTrait;

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
        return $this->belongsTo('SpaceXStats\Models\Object');
    }

    public function user() {
        return $this->belongsTo('SpaceXStats\Models\User')->select(array('user_id', 'username'));
    }

    // Attribute Accessors
    public function getCommentAttribute() {
        if ($this->isHidden || $this->trashed()) {
            return null;
        }
        return $this->attributes['comment'];
    }

    public function getOwnershipAttribute() {
        return Auth::id() == $this->attributes['user_id'];
    }

    // Attribute Mutators
    public function setDepthAttribute() {
        if ($this->parent == 0) {
            $depth = 0;
        } else {
            $parentComment = Comment::find($this->parent);
            $depth = $parentComment->depth + 1;
        }
        $this->attributes['depth'] = $depth;
    }
}
