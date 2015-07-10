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
        $object = Object::with('userNote')->find($object_id);

        $viewToMake = View::make('missionControl.objects.get', array(
            'object' => $object
        ));
        
        if ($object->visibility == 'Public' && $object->status == 'Published') {
            return $viewToMake;

        } elseif ($object->visibility == 'Default' && $object->status == 'Published') {
            if (Auth::isSubscriber()) {
                return $viewToMake;
            }
            return App::abort(401);

        } elseif ($object->visibility == 'Hidden' || $object->status == 'Queued' || $object->status == 'New') {
            if (Auth::isAdmin()) {
                return $viewToMake;
            }
            return App::abort(401);

        }

        return App::abort(401);
    }

    // GET
    // missioncontrol/object/{object_id}/edit
    public function edit($object_id) {

    }

    // AJAX POST
    // missioncontrol/object/{object_id}/note
    public function note($object_id) {
        if (Auth::member()) {
            $usernote = Note::where('user_id', Auth::user()->id)->where('object_id', $object_id)->get();

            if ($usernote->count() > 0) {
                if (Input::get('action') == 'update') {
                    $usernote->note = Input::get('note', null);
                    $usernote->save();

                    return Response::json('update');

                } elseif (Input::get('action') == 'delete') {
                    $usernote->delete();

                    return Response::json('delete');
                }
            } else {
                Note::create(array(
                    'user_id' => Auth::user()->id,
                    'object_id' => $object_id,
                    'note' => Input::get('note', null)
                ));

                return Response::json('create');
            }
        } else {
            return Response::json(false, 400);
        }
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