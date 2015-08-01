<?php

class ReviewController extends BaseController {
    // GET
    public function index() {
        return View::make('missionControl.review.index', array(
            'title' => 'Review',
            'currentPage' => 'review'
        ));
    }

    // AJAX GET
    public function get() {
        $objectsToReview = Object::queued()->with('user', 'tags')->get();
        return Response::json($objectsToReview);
    }

    // AJAX POST
    public function update($object_id) {
        if (Input::has(['status', 'visibility'])) {

            $object = Object::find($object_id);

            if (Input::get('status') == "Published") {
                // if it is a file, add it and thumbs to S3
                $s3 = AWS::get('s3');

                // Put the necessary objects
                if ($object->hasFile()) {
                    $s3->putObject([
                        'Bucket' => Credential::AWSS3Bucket,
                        'Key' => $object->filename,
                        'Body' => fopen(public_path() . $object->media, 'rb'),
                        'ACL' =>  \Aws\S3\Enum\CannedAcl::PUBLIC_READ,
                    ]);
                    unlink($object->media);
                }

                if ($object->hasThumbs()) {
                    $s3->putObject([
                        'Bucket' => Credential::AWSS3BucketLargeThumbs,
                        'Key' => $object->thumb_filename,
                        'Body' => fopen(public_path() . $object->media_thumb_large, 'rb'),
                        'ACL' =>  \Aws\S3\Enum\CannedAcl::PUBLIC_READ,
                        'StorageClass' => \Aws\S3\Enum\StorageClass::REDUCED_REDUNDANCY
                    ]);
                    unlink($object->media_thumb_large);

                    $s3->putObject([
                        'Bucket' => Credential::AWSS3BucketSmallThumbs,
                        'Key' => $object->thumb_filename,
                        'Body' => fopen(public_path() . $object->media_thumb_small, 'rb'),
                        'ACL' =>  \Aws\S3\Enum\CannedAcl::PUBLIC_READ,
                        'StorageClass' => \Aws\S3\Enum\StorageClass::REDUCED_REDUNDANCY
                    ]);
                    unlink($object->media_thumb_small);
                }

                $object->fill(Input::only(['status', 'visibility']));
                $object->actioned_at = \Carbon\Carbon::now();

                // Add the object to our elasticsearch node
                Search::indexObject($object);
                $object->save();

            } elseif (Input::get('status') == "Deleted") {
                $object->delete();
            }

            return Response::json(true);
        } else {
            return Response::json(false, 400);
        }
    }
}

