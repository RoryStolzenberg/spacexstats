<?php

class QuestionsController extends BaseController {

	// GET
	public function index() {
		$questions = Question::all();

		return View::make('questions.faq', array(
			'title' => 'SpaceX Questions',
			'currentPage' => 'questions',
			'questionCount' => $questions->count(),
			'questions' => $questions
		));
	}

	// AJAX POST
	public function getQuestions() {
		return Response::json(Question::all()->toArray());
	}
}