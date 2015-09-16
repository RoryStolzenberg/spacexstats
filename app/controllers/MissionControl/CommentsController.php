<?php
class CommentsController extends BaseController {

    // AJAX GET
    // /{$object_id}/comments
    public function comments($object_id) {
        $object = Object::find($object_id);
        return Response::json($object->commentTree);
    }
}