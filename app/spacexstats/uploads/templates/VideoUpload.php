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
        return \Object::create(array(
            'user_id' => \Auth::id(),
            'type' => MissionControlType::Video,
            'size' => $this->fileinfo['size'],
            'filetype' => $this->fileinfo['filetype'],
            'mimetype' => $this->fileinfo['mime'],
            'original_name' => $this->fileinfo['original_name'],
            'filename' => $this->fileinfo['filename'],
            'thumb_large' => $this->setThumbnail('large'),
            'thumb_small' => $this->setThumbnail('small'),
            'cryptographic_hash' => $this->getCryptographicHash(),
            'dimension_width' => $this->getDimensions('width'),
            'dimension_height' => $this->getDimensions('height'),
            'length' => $this->getLength(),
            'status' => 'New'
        ));
    }

    private function setThumbnail($size) {
        $lengthDimension = ($size == 'small') ? $this->smallThumbnailSize : $this->largeThumbnailSize;

        // Set the point in the video to extract the frame at approximately 10% of the video length;
        $frameExtractionPoint = (int)round($this->getLength() / 10);

        // Open the video and extract a frame at 10% of the video's duration
        $video = $this->ffmpeg->open($this->directory['full'] . $this->fileinfo['filename']);
        $frame = $video->frame(\FFMpeg\Coordinate\TimeCode::fromSeconds($frameExtractionPoint));

        // create an Imagick instance
        $frame->thumbnailImage($lengthDimension, $lengthDimension, true);
        $frame->writeImage($this->getImagickSafeDirectory($size) . $this->fileinfo['filename_without_extension'] . '.jpg');

        return $this->directory[$size] . $this->fileinfo['filename_without_extension'] . '.jpg';
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