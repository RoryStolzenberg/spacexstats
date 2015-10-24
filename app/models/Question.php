<?php
namespace SpaceXStats\Models;
use Illuminate\Database\Eloquent\Model;

class Question extends Model {

	protected $table = 'questions';
	protected $primaryKey = 'question_id';
    public $timestamps = true;

    protected $hidden = [];
    protected $appends = [];
    protected $fillable = [];
    protected $guarded = [];

	// Relations
}