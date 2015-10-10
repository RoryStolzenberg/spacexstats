<?php 
 namespace AppHttpControllers;
class CommentsController extends Controller {

    // AJAX GET
    // /{$object_id}/comments
    public function objectComments($object_id) {
        $object = Object::find($object_id);
        return Response::json($object->commentTree);
    }

    // AJAX POST
    // /{$object_id}/comments/add
    public function addComment($object_id) {

        Comment::create(array(
            'object_id' => $object_id,
            'user_id' => Auth::user()->user_id,
            'comment' => Input::get('comment.comment'),
            'parent' => Input::get('comment.parent')
        ));

        return Response::json(null, 204);
    }

    // AJAX DELETE
    // /{$object_id}/comments/{$comment_id}/delete
    public function deleteComment($object_id, $comment_id) {
        $comment = Comment::find($comment_id);

        // Make sure that the request for deletion is either coming from an admin or from the user who owns the comment
        if (Auth::isAdmin() || $comment->user_id == Auth::user()->user_id) {
            $comment->delete();
            return Response::json(null, 204);
        }
        return Response::json(null, 402);
    }

    // AJAX PATCH
    // /{$object_id}/comments/{$comment_id}/delete
    public function editComment($object_id, $comment_id) {
        $comment = Comment::find($comment_id);

        // Make sure that the request for editing is from the user who owns the comment
        if ($comment->user_id == Auth::user()->user_id) {
            $comment->comment = Input::get('comment.comment');
            $comment->save();
            return Response::json(null, 204);
        }
        return Response::json(null, 402);
    }
}