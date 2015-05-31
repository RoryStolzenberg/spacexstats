<?php
namespace SpaceXStats\UploadTemplates;

class AudioUpload extends GenericUpload implements UploadInterface {
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
        return Object::create(array(
            'user_id' => Auth::id(),
            'type' => MissionControlType::Audio,
            'size' => $this->fileinfo['size'],
            'filetype' => $this->fileinfo['filetype'],
            'mimetype' => $this->fileinfo['mime'],
            'original_name' => $this->fileinfo['original_name'],
            'filename' => $this->fileinfo['filename'],
            'length' => $this->getLength(),
            'status' => 'new'
        ));
    }

    private function getLength() {
        return round($this->ffprobe->format($this->directory['full'] . $this->fileinfo['filename'])->get('duration'));
    }
}