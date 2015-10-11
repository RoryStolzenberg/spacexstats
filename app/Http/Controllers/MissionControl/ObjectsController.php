<?php
 namespace SpaceXStats\Http\Controllers;
use SpaceXStats\Library\DeltaVCalculator;
use \SpaceXStats\Enums\MissionControlType;

class ObjectsController extends Controller {

    // GET
    // missioncontrol/objects/{object_id}
    public function get($object_id) {
        $object = Object::find($object_id);

        // Item has been viewed, increment!
        $object->incrementViewCounter();

        // Determine what type of object it is to show the correct view
        $viewType = strtolower(MissionControlType::getKey($object->type));

        // Object is visible to everyone and is published
        if ($object->visibility == 'Public' && $object->status == 'Published') {

            if (Auth::isSubscriber()) {
                JavaScript::put([
                    'totalFavorites' => $object->favorites()->count(),
                    'isFavorited' => Auth::user()->favorites()->where('object_id', $object_id)->first(),
                    'userNote' => Auth::user()->notes()->where('object_id', $object_id)->first(),
                    'object' => $object
                ]);
            }

            return View::make('missionControl.objects.' . $viewType , ['object' => $object]);

        // Object is visible to subscribers, is published, and the logged in user is also a subscriber
        // or the user is an admin
        } elseif (($object->visibility == 'Default' && $object->status == 'Published' && Auth::isSubscriber()) || Auth::isAdmin()) {

                // Inject dynamic data into page
                JavaScript::put([
                    'totalFavorites' => $object->favorites()->count(),
                    'isFavorited' => Auth::user()->favorites()->where('object_id', $object_id)->first(),
                    'userNote' => Auth::user()->notes()->where('object_id', $object_id)->first(),
                    'object' => $object
                ]);

                return View::make('missionControl.objects.' . $viewType , ['object' => $object]);
        }

        return App::abort(401);
    }

    /**
     * GET/PATCH, /missioncontrol/objects/{objectId}/edit. Allows for the editing of objects by mission
     * control subscribers and admins.
     *
     * @param $object_id    The object to edit.
     */
    public function edit($object_id) {
        $object = Object::find($object_id);

        if (Request::isMethod('get')) {

            JavaScript::put([
               'object' => $object
            ]);

            return View::make('missionControl.objects.edit.edit', ['object' => $object]);

        } else if (Request::isMethod('patch')) {

        }
    }

    /**
     * POST, /missioncontrol/objects/{objectId}/revert/{objectRevisionId}.
     *
     * @param $objectId
     * @param $objectRevisionId
     */
    public function revert($objectId, $objectRevisionId) {

    }

    // AJAX POST/PATCH/DELETE
    // missioncontrol/objects/{object_id}/note
    public function note($object_id) {
        if (Auth::isSubscriber()) {

            // Create
            if (Request::isMethod('post')) {
                $usernote = Note::create(array(
                    'user_id' => Auth::user()->user_id,
                    'object_id' => $object_id,
                    'note' => Input::get('note', null)
                ));
                $usernote->note = Input::get('note', null);
                $usernote->save();

            // Edit
            } elseif (Request::isMethod('patch')) {
                $usernote = Auth::user()->notes()->where('object_id', $object_id)->firstOrFail();
                $usernote->note = Input::get('note', null);
                Auth::user()->notes()->save($usernote);

            // Delete
            } elseif (Request::isMethod('delete')) {
                $usernote = Auth::user()->notes()->where('object_id', $object_id)->firstOrFail();
                $usernote->delete();
            }
            return Response::json(null, 204);
        }
        return Response::json(false, 401);
    }

    // AJAX POST/DELETE
    // missioncontrol/objects/{object_id}/favorite
    public function favorite($object_id) {
        if (Auth::isSubscriber()) {

            // Create Favorite
            if (Request::isMethod('post')) {

                if (Auth::user()->favorites()->count() == 0) {
                    Favorite::create(array(
                        'object_id' => $object_id,
                        'user_id' => Auth::user()->user_id
                    ));
                }

            // Delete Favorite
            } elseif (Request::isMethod('delete')) {
                Auth::user()->favorites()->where('object_id', $object_id)->firstOrFail()->delete();
            }

            return Response::json(null, 204);
        }

        return Response::json(false, 401);
    }

    // AJAX POST
    // missioncontrol/object/{object_id}/download
    public function download($object_id) {

        // Only increment the downloads table if the same user has not downloaded it in the last hour (just like views)
        $mostRecentDownload = Download::where('user_id', Auth::user()->user_id)->where('object_id', $object_id)->first();

        if ($mostRecentDownload === null || $mostRecentDownload->created_at->diffInSeconds(Carbon\Carbon::now()) > 3600) {
            Download::create(array(
                'user_id' => Auth::user()->user_id,
                'object_id' => $object_id
            ));
        }
        return Response::json(null, 204);
    }
}