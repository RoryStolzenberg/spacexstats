<?php
use SpaceXStats\Library\DeltaVCalculator;

class ObjectsController extends BaseController {
    protected $dVCalculator;

    public function __construct(DeltaVCalculator $dVCalculator) {
        $this->dVCalculator = $dVCalculator;
    }

    // GET
    // missioncontrol/object/{object_id}
    public function get($object_id) {
        $object = Object::find($object_id);
        
        if ($object->visibility == 'Public' && $object->status == 'Published') {
            return View::make('missionControl.objects.get', array(
                'object' => $object
            ));

        } elseif ($object->visibility == 'Default' && $object->status == 'Published') {
            if (Auth::isSubscriber()) {
                return View::make('missionControl.objects.get', array(
                    'object' => $object,
                    'userNote' => Auth::user()->notes()->where('object_id', $object_id)->first()
                ));
            }
            return App::abort(401);

        } elseif ($object->visibility == 'Hidden' || $object->status == 'Queued' || $object->status == 'New') {
            if (Auth::isAdmin()) {
                return View::make('missionControl.objects.get', array(
                    'object' => $object,
                    'userNote' => Auth::user()->notes()->where('object_id', $object_id)->first()
                ));
            }
            return App::abort(401);

        }
        return App::abort(401);
    }

    // GET
    // missioncontrol/object/{object_id}/edit
    public function edit($object_id) {

    }

    // AJAX POST/PATCH/DELETE
    // missioncontrol/object/{object_id}/note
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

    // AJAX POST
    // missioncontrol/object/{object_id}/favorite
    public function favorite($object_id) {
        if (Auth::member()) {
            $favorite = Favorite::where('user_id', Auth::user()->id)->where('object_id', $object_id)->get();

            if ($favorite->count() > 0) {
                $favorite->delete();

                return Response::json('removed');
            } else {
                Favorite::create(array(
                    'user_id' => Auth::user()->id,
                    'object_id' => $object_id
                ));

                return Response::json('added');
            }
        } else {
            return Response::json();
        }
    }

    // AJAX POST
    // missioncontrol/object/{object_id}/download
    public function download($object_id) {

    }

    // AJAX POST
    public function calculateDeltaV() {
        if (Auth::isSubscriber()) {
            return Response::json(null);
        } else {
            return Response::json(null, 401);
        }
    }
}