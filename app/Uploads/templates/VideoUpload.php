<?php
namespace SpaceXStats\Uploads\Templates;

use FFMpeg\Coordinate\TimeCode;
use Illuminate\Support\Facades\Auth;
use SpaceXStats\Library\Enums\MissionControlType;
use SpaceXStats\Library\Enums\ObjectPublicationStatus;
use FFMpeg\FFProbe;
use FFMpeg\FFMpeg;
use SpaceXStats\Models\Object;

class VideoUpload extends GenericUpload implements UploadInterface {
    public function __construct($file) {
        parent::__construct($file);

        $this->ffprobe = FFProbe::create([
            'ffmpeg.binaries' => env('FFMPEG'),
            'ffprobe.binaries' => env('FFPROBE')
        ]);

        $this->ffmpeg = FFMpeg::create([
            'ffmpeg.binaries' => env('FFMPEG'),
            'ffprobe.binaries' => env('FFPROBE')
        ]);
    }

    public function addToMissionControl() {
        $this->setThumbnails();

        return Object::create([
            'user_id' => Auth::id(),
            'type' => MissionControlType::Video,
            'size' => $this->fileinfo['size'],
            'filetype' => $this->fileinfo['filetype'],
            'mimetype' => $this->fileinfo['mime'],
            'original_name' => $this->fileinfo['original_name'],
            'filename' => $this->fileinfo['filename'],
            'thumb_filename' => $this->getThumbnail(),
            'has_temporary_file' => true,
            'has_temporary_thumbs' => true,
            'cryptographic_hash' => $this->getCryptographicHash(),
            'dimension_width' => $this->getDimensions('width'),
            'dimension_height' => $this->getDimensions('height'),
            'duration' => $this->getLength(),
            'status' => ObjectPublicationStatus::NewStatus
        ]);
    }

    private function setThumbnails() {
        $thumbnailsToCreate = ['small', 'large'];

        // Set the point in the video to extract the frame at approximately 10% of the video length;
        $frameExtractionPoint = (int)round($this->getLength() / 10);

        // Open the video and extract a frame at 10% of the video's duration
        $video = $this->ffmpeg->open($this->directory['full'] . $this->fileinfo['filename']);
        $frame = $video->frame(TimeCode::fromSeconds($frameExtractionPoint));

        // Save frame to temporary location
        create_if_does_not_exist(public_path($this->directory['frames']));
        $frame->save($this->directory['frames'] . $this->fileinfo['filename_without_extension'] . '.jpg');

        foreach ($thumbnailsToCreate as $size) {
            $lengthDimension = ($size == 'small') ? $this->smallThumbnailSize : $this->largeThumbnailSize;

            // create an Imagick instance
            $image = new \Imagick(public_path($this->directory['frames'] . $this->fileinfo['filename_without_extension'] . '.jpg'));
            $image->thumbnailImage($lengthDimension, $lengthDimension, true);

            create_if_does_not_exist(public_path($this->directory[$size]));
            $image->writeImage(public_path($this->directory[$size] . $this->fileinfo['filename_without_extension'] . '.jpg'));
        }

        // Delete the temporary frame
        unlink($this->directory['frames'] . $this->fileinfo['filename_without_extension'] . '.jpg');
    }

    private function getThumbnail() {
        return $this->fileinfo['filename_without_extension'] . '.jpg';
    }

    private function getDimensions($dimension) {
        $dimensionsObject = $this->ffprobe->streams($this->directory['full'] . $this->fileinfo['filename'])->videos()->first()->getDimensions();
        if ($dimension == 'width') {
            return $dimensionsObject->getWidth();
        } elseif ($dimension == 'height') {
            return $dimensionsObject->getHeight();
        }
    }

    private function getLength() {
        return round($this->ffprobe->format($this->directory['full'] . $this->fileinfo['filename'])->get('duration'));
    }
}