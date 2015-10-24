<?php
namespace SpaceXStats\Http\Controllers;

use SpaceXStats\Models\Question;

class QuestionsController extends Controller {

	// GET
	public function index() {
		return view('questions.faq', array(
            'questionCount' => Question::all()->count()
        ));
	}

	// AJAX GET
	public function get() {
		return response()->json(Question::all());
	}
}