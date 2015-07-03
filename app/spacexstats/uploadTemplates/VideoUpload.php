<?php
namespace SpaceXStats\UploadTemplates;

class VideoUpload extends GenericUpload implements UploadInterface {
    protected
        $smallThumbnailSize = 200,
        $largeThumbnailSize = 800;

    public function __construct($file) {
        parent::__construct($file);

        $this->ffprobe = FFMpeg\FFProbe::create([
            'ffmpeg.binaries' => Credential::FFMpeg,
            'ffprobe.binaries' => Credential::FFProbe
        ]);

        $this->ffmpeg = \FFMpeg\FFMpeg::create([
            'ffmpeg.binaries' => Credential::FFMpeg,
            'ffprobe.binaries' => Credential::FFProbe
        ]);
    }

    public function addToMissionControl() {
        $this->addThumbnails();

        return Object::create(array(
            'user_id' => Auth::id(),
            'type' => MissionControlType::Video,
            'size' => $this->fileinfo['size'],
            'filetype' => $this->fileinfo['filetype'],
            'mimetype' => $this->fileinfo['mime'],
            'original_name' => $this->fileinfo['original_name'],
            'filename' => $this->fileinfo['filename'],
            'dimension_width' => $this->getDimensions('width'),
            'dimension_height' => $this->getDimensions('height'),
            'length' => $this->getLength(),
            'status' => 'new'
        ));
    }

    private function addThumbnails() {
        $this->setThumbnail('small');
        $this->setThumbnail('large');
    }

    private function setThumbnail($size) {
        $lengthDimension = ($size == 'small') ? $this->smallThumbnailSize : $this->largeThumbnailSize;

        // Set the point in the video to extract the frame at approximately 10% of the video length;
        $frameExtractionPoint = (int)round($this->getLength() / 10);

        // Open the video and extract a frame at 10% of the video's duration
        $video = $this->ffmpeg->open($this->directory['full'] . $this->fileinfo['filename']);
        $frame = $video->frame(\FFMpeg\Coordinate\TimeCode::fromSeconds($frameExtractionPoint));

        // create an Imagick instance
        $image = new \Imagick($frame);
        $image->thumbnailImage($lengthDimension, $lengthDimension, true);
        $image->writeImage($this->directory[$size] . $this->fileinfo['filename_without_extension'] . '.jpg');

        return $this->directory[$size] . $this->fileinfo['filename_without_extension'] . '.jpg';
    }

    private function getDimensions($dimension) {
        return null;
    }

    private function getLength() {
        return round($this->ffprobe->format($this->directory['full'] . $this->fileinfo['filename'])->get('duration'));
    }
}