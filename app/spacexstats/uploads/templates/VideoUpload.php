<?php
namespace SpaceXStats\Uploads\Templates;

use SpaceXStats\Enums\MissionControlType;
use FFMpeg\FFProbe;
use FFMpeg\FFMpeg;

class VideoUpload extends GenericUpload implements UploadInterface {
    public function __construct($file) {
        parent::__construct($file);

        $this->ffprobe = FFProbe::create([
            'ffmpeg.binaries' => \Credential::FFMpeg,
            'ffprobe.binaries' => \Credential::FFProbe
        ]);

        $this->ffmpeg = FFMpeg::create([
            'ffmpeg.binaries' => \Credential::FFMpeg,
            'ffprobe.binaries' => \Credential::FFProbe
        ]);
    }

    public function addToMissionControl() {
        $this->setThumbnails();

        return \Object::create(array(
            'user_id' => \Auth::id(),
            'type' => MissionControlType::Video,
            'size' => $this->fileinfo['size'],
            'filetype' => $this->fileinfo['filetype'],
            'mimetype' => $this->fileinfo['mime'],
            'original_name' => $this->fileinfo['original_name'],
            'filename' => $this->fileinfo['filename'],
            'thumb_filename' => $this->getThumbnail(),
            'cryptographic_hash' => $this->getCryptographicHash(),
            'dimension_width' => $this->getDimensions('width'),
            'dimension_height' => $this->getDimensions('height'),
            'length' => $this->getLength(),
            'status' => 'New'
        ));
    }

    private function setThumbnails() {
        $thumbnailsToCreate = ['small', 'large'];

        // Set the point in the video to extract the frame at approximately 10% of the video length;
        $frameExtractionPoint = (int)round($this->getLength() / 10);

        // Open the video and extract a frame at 10% of the video's duration
        $video = $this->ffmpeg->open($this->directory['full'] . $this->fileinfo['filename']);
        $frame = $video->frame(\FFMpeg\Coordinate\TimeCode::fromSeconds($frameExtractionPoint));

        // Save frame to temporary location
        $frame->save($this->directory['frames'] . $this->fileinfo['filename_without_extension'] . '.jpg');

        foreach ($thumbnailsToCreate as $size) {
            $lengthDimension = ($size == 'small') ? $this->smallThumbnailSize : $this->largeThumbnailSize;

            // create an Imagick instance
            $image = new \Imagick($this->getImagickSafeDirectory('frames') . $this->fileinfo['filename_without_extension'] . '.jpg');
            $image->thumbnailImage($lengthDimension, $lengthDimension, true);
            $image->writeImage($this->getImagickSafeDirectory($size) . $this->fileinfo['filename_without_extension'] . '.jpg');
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