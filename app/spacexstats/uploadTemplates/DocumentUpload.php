<?php
namespace SpaceXStats\UploadTemplates;

use SpaceXStats\Enums\MissionControlType;

class DocumentUpload extends GenericUpload implements UploadInterface {
    public function __construct($file) {
        parent::__construct($file);
    }

    public function addToMissionControl() {
        return \Object::create(array(
            'user_id' => \Auth::id(),
            'type' => MissionControlType::Document,
            'size' => $this->fileinfo['size'],
            'filetype' => $this->fileinfo['filetype'],
            'mimetype' => $this->fileinfo['mime'],
            'original_name' => $this->fileinfo['original_name'],
            'filename' => $this->fileinfo['filename'],
            'thumb_large' => $this->setThumbnail('large'),
            'thumb_small' => $this->setThumbnail('small'),
            'cryptographic_hash' => $this->getCryptographicHash(),
            'length' => $this->getPageCount(),
            'status' => 'New'
        ));
    }

    private function setThumbnail($size) {
        $filetype = $this->fileinfo['filetype'];
        $mime = $this->fileinfo['mime'];

        // PDFs
        if ($filetype == 'pdf' && $mime == 'application/pdf') {

        } elseif ($filetype ==)
    }

    private function getPageCount() {

    }
}