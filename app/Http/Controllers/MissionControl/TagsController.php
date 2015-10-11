<?php
 namespace SpaceXStats\Http\Controllers;
class TagsController extends Controller {
    // AJAX GET
    // /tags/all
    public function all() {
        return Response::json(Tag::all(['tag_id', 'name', 'description']));
    }

    // GET
    // /tags/{tag}
    public function get($tag) {
        return View::make('missionControl.tags.get', array(
            'tag' => Tag::where('name', $tag)->with('objects')->firstOrFail()
        ));
    }

    // GET
    // /tags/{tag}/edit
    public function edit($tag) {
        return View::make('missionControl.tags.edit', array(
            'tag' => Tag::where('name', $tag)->firstOrFail()
        ));
    }
}
