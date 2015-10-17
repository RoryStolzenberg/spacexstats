<?php
namespace SpaceXStats\Uploads;

use SpaceXStats\Library\Enums\MissionControlType;

class Checker {
    protected $file;

    protected $maxFileSize = 1073741824; // 1GB

    protected $mimetypes = [
        'Image'     => ['image/jpeg', 'image/pjpeg', 'image/png'],
        'GIF'       => ['image/gif'],
        'Video'     => ['video/mp4', 'video/mpeg', 'video/x-ms-wmv', 'video/x-ms-asf'],
        'Document'  => ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'text/plain', 'text/rtf', 'application/rtf'],
        'Audio'     => ['audio/mp3', 'audio/mpeg']
    ];

    protected $filetypes = [
        'Image'     => ['jpg', 'jpeg', 'png'],
        'GIF'       => ['gif'],
        'Video'     => ['mp4', 'wmv'],
        'Document'  => ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'txt', 'rtf'],
        'Audio'     => ['mp3']
    ];

    public function check($file) {
        $this->file = $file;
        return ($this->file->isValid() === true && $this->customChecks() === true);
    }

    public function errors() {
        if ($this->file->getError() !== UPLOAD_ERR_OK || $this->customChecks() === false) {
            return array_merge(array($this->file->getError()), $this->customChecks(false));
        }
        return false;
    }

    private function customChecks($boolean = false) {
        $customErrors = [];

        if ($this->file->getClientSize() > $this->maxFileSize) {
            $customErrors[] = 9;
        }

        // Check filetype
        if (!in_array(strtolower($this->file->getClientOriginalExtension()), array_flatten($this->filetypes))) {
            $customErrors[] = 10;
        }

        // Check mimetype
        if (!in_array($this->file->getMimeType(), array_flatten($this->mimetypes))) {
            $customErrors[] = 11;
        }

        // Check if there is a mismatch between the filetype and the mimetype
        if ($this->resolve() === false) {
            $customErrors[] = 12;
        }

        if (empty($customErrors)) {
            return true;
        } else {
            return ($boolean === true) ? false : $customErrors;
        }
    }

    public function create() {
        switch ($this->resolve()) {
            case MissionControlType::Image:     return new Templates\ImageUpload($this->file);
            case MissionControlType::GIF:       return new Templates\GIFUpload($this->file);
            case MissionControlType::Audio:     return new Templates\AudioUpload($this->file);
            case MissionControlType::Video:     return new Templates\VideoUpload($this->file);
            case MissionControlType::Document:  return new Templates\DocumentUpload($this->file);
        }
    }

    private function resolve() {
        foreach ($this->filetypes as $mediaType => $arrayOfFileTypes) {
            if (in_array(strtolower($this->file->getClientOriginalExtension()), $arrayOfFileTypes) && in_array($this->file->getMimeType(), $this->mimetypes[$mediaType])) {
                return MissionControlType::fromString($mediaType);
            }
        }
        return false;
    }
}