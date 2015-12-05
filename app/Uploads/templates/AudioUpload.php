<?php
namespace SpaceXStats\Uploads\Templates;

use SpaceXStats\Library\Enums\MissionControlType;
use SpaceXStats\Library\Enums\ObjectPublicationStatus;
use FFMpeg\FFProbe;
use FFMpeg\FFMpeg;
use SpaceXStats\Models\Object;

class AudioUpload extends GenericUpload implements UploadInterface {
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
        return Object::create(array(
            'user_id' => \Auth::id(),
            'type' => MissionControlType::Audio,
            'size' => $this->fileinfo['size'],
            'filetype' => $this->fileinfo['filetype'],
            'mimetype' => $this->fileinfo['mime'],
            'original_name' => $this->fileinfo['original_name'],
            'filename' => $this->fileinfo['filename'],
            'has_temporary_file' => true,
            'cryptographic_hash' => $this->getCryptographicHash(),
            'duration' => $this->getLength(),
            'status' => ObjectPublicationStatus::NewStatus
        ));
    }

    private function getLength() {
        return round($this->ffprobe->format($this->directory['full'] . $this->fileinfo['filename'])->get('duration'));
    }
}