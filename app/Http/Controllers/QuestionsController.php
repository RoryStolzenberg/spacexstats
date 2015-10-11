<?php
 namespace SpaceXStats\Http\Controllers;

class QuestionsController extends Controller {

	// GET
	public function index() {
		$questions = Question::all();

		return view('questions.faq', array(
			'questionCount' => $questions->count(),
			'questions' => $questions
		));
	}

	// AJAX POST
	public function getQuestions() {
		return response()->json(Question::all()->toArray());
	}
}