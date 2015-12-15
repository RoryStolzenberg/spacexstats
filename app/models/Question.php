<?php
namespace SpaceXStats\Models;

use Illuminate\Database\Eloquent\Model;
use Parsedown;

class Question extends Model {

	protected $table = 'questions';
	protected $primaryKey = 'question_id';
    public $timestamps = true;

    protected $hidden = [];
    protected $appends = ['slug', 'icon'];
    protected $fillable = [];
    protected $guarded = [];

    public function getSlugAttribute() {
        return str_slug($this->question);
    }

	public function getAnswerAttribute() {
        return Parsedown::instance()->text($this->attributes['answer']);
    }

    public function getIconAttribute() {
        return '/images/icons/faq/' + $this->type + '.png';
    }
}