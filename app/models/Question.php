<?php
namespace SpaceXStats\Models;

class Question extends Model {

	protected $table = 'questions';
	protected $primaryKey = 'question_id';
    public $timestamps = false;

    protected $hidden = [];
    protected $appends = [];
    protected $fillable = [];
    protected $guarded = [];

	// Relations
}