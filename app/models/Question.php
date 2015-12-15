<?php
namespace SpaceXStats\Models;
use Illuminate\Database\Eloquent\Model;

class Question extends Model {

	protected $table = 'questions';
	protected $primaryKey = 'question_id';
    public $timestamps = true;

    protected $hidden = [];
    protected $appends = ['slug'];
    protected $fillable = [];
    protected $guarded = [];

    public function getSlugAttribute() {
        return str_slug($this->question);
    }

	public function getAnswerMdAttribute() {
        return Parsedown::instance()->text($this->answer);
    }

    public function getIconAttribute() {
        return '/images/icons/faq/' + $this->type + '.png';
    }
}