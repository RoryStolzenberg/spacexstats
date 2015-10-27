<?php 
namespace SpaceXStats\Http\Controllers\MissionControl;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use SpaceXStats\Http\Controllers\Controller;
use SpaceXStats\Models\Comment;
use SpaceXStats\Models\Object;

class CommentsController extends Controller {

    // AJAX GET
    // /{$object_id}/comments
    public function commentsForObject($object_id) {
        $object = Object::find($object_id);
        return response()->json($object->commentTree);
    }

    // AJAX POST
    // /{$object_id}/comments/add
    public function create($object_id) {

        $newComment = Comment::create(array(
            'object_id' => $object_id,
            'user_id' => Auth::id(),
            'comment' => Input::get('comment.comment'),
            'parent' => Input::get('comment.parent')
        ));

        $comment = Comment::where('comment_id', $newComment->comment_id)->with('user')->first();

        return response()->json($comment);
    }

    // AJAX DELETE
    // /{$object_id}/comments/{$comment_id}/delete
    public function delete($object_id, $comment_id) {

        $comment = Comment::find($comment_id);

        // Make sure that the request for deletion is either coming from an admin or from the user who owns the comment
        if (Auth::isAdmin() || $comment->user_id == Auth::id()) {
            $comment->delete();
            return response()->json(null, 204);
        }
        return response()->json(null, 402);
    }

    // AJAX PATCH
    // /{$object_id}/comments/{$comment_id}/edit
    public function edit($object_id, $comment_id) {
        $comment = Comment::find($comment_id);

        // Make sure that the request for editing is from the user who owns the comment
        if ($comment->user_id == Auth::id()) {
            $comment->comment = Input::get('comment.comment');
            $comment->save();
            return response()->json($comment, 200);
        }
        return response()->json(null, 402);
    }
}