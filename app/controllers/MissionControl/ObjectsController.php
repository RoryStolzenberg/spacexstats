<?php
use SpaceXStats\Library\DeltaVCalculator;

class ObjectsController extends BaseController {

    // GET
    // missioncontrol/objects/{object_id}
    public function get($object_id) {
        $object = Object::find($object_id);

        $object->incrementViewcounter();

        // Object is visible to everyone and is published
        if ($object->visibility == 'Public' && $object->status == 'Published') {

            return View::make('missionControl.objects.get', array(
                'object' => $object
            ));

        // Object is visible to subscribers, is published, and the logged in user is also a subscriber
        } elseif ($object->visibility == 'Default' && $object->status == 'Published' && Auth::isSubscriber()) {

                // Inject dynamic data into page
                JavaScript::put([
                    'totalFavorites' => $object->favorites()->count(),
                    'isFavorited' => Auth::user()->favorites()->where('object_id', $object_id)->first(),
                    'userNote' => Auth::user()->notes()->where('object_id', $object_id)->first(),
                    'object' => $object
                ]);

                return View::make('missionControl.objects.get', array(
                    'object' => $object
                ));

        // Object is hidden and not published, and the logged in user is an admin
        } elseif ($object->visibility == 'Hidden' || $object->status != "Published" && Auth::isAdmin()) {

                // Inject dynamic data into page
                JavaScript::put([
                    'totalFavorites' => $object->favorites()->count(),
                    'isFavorited' => Auth::user()->favorites()->where('object_id', $object_id)->first(),
                    'object' => $object,
                    'userNote' => Auth::user()->notes()->where('object_id', $object_id)->first()
                ]);

                return View::make('missionControl.objects.get', array(
                    'object' => $object
                ));
        }
        return App::abort(401);
    }

    // GET
    // missioncontrol/objects/{object_id}/edit
    public function edit($object_id) {

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

                return Response::json(true, 200);

            // Edit
            } elseif (Request::isMethod('patch')) {
                $usernote = Auth::user()->notes()->where('object_id', $object_id)->firstOrFail();
                $usernote->note = Input::get('note', null);
                Auth::user()->notes()->save($usernote);

                return Response::json(true, 200);

            // Delete
            } elseif (Request::isMethod('delete')) {
                $usernote = Auth::user()->notes()->where('object_id', $object_id)->firstOrFail();
                $usernote->delete();

                return Response::json(true, 200);
            }
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

            return Response::json(true, 200);
        }

        return Response::json(false, 401);
    }

    // AJAX POST
    // missioncontrol/object/{object_id}/download
    public function download($object_id) {
        // Check the request path is valid
        if (Request::path()) {
            // Retrieve file

            // Add entry to the downloads table
            Download::create(array(
                'user_id' => Auth::user()->user_id,
                'object_id' => $object_id
            ));

            // Present file download
        }
    }
}