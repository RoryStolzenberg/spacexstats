<?php
 namespace SpaceXStats\Http\Controllers;

class QuestionsController extends Controller {

	// GET
	public function index() {
		$questions = Question::all();

		return View::make('questions.faq', array(
			'questionCount' => $questions->count(),
			'questions' => $questions
		));
	}

	// AJAX POST
	public function getQuestions() {
		return Response::json(Question::all()->toArray());
	}
}