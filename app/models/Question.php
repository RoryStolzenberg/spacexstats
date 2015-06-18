<?php

class Question extends Eloquent {

	protected $table = 'questions';
	protected $primaryKey = 'question_id';
    protected $timestamps = false;

    protected $hidden = [];
    protected $appends = [];
    protected $fillable = [];
    protected $guarded = [];

	// Relations
}