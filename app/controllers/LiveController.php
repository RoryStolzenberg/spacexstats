<?php

class LiveController extends BaseController {

    // live, GET.
    public function live() {
        return View::make('live');
    }
}