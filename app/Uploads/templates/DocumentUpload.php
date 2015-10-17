<?php
namespace SpaceXStats\Uploads\Templates;

use SpaceXStats\Library\Enums\MissionControlType;
use SpaceXStats\Library\Enums\ObjectPublicationStatus;
use SpaceXStats\Models\Object;

class DocumentUpload extends GenericUpload implements UploadInterface {
    public function __construct($file) {
        parent::__construct($file);
    }

    public function addToMissionControl() {
        $this->setThumbnails();

        return Object::create(array(
            'user_id' => \Auth::id(),
            'type' => MissionControlType::Document,
            'size' => $this->fileinfo['size'],
            'filetype' => $this->fileinfo['filetype'],
            'mimetype' => $this->fileinfo['mime'],
            'original_name' => $this->fileinfo['original_name'],
            'filename' => $this->fileinfo['filename'],
            'thumb_filename' => $this->getThumbnail(),
            'has_temporary_file' => true,
            'has_temporary_thumbs' => $this->fileinfo['filetype'] == 'pdf' && $this->fileinfo['mime'] == 'application/pdf',
            'cryptographic_hash' => $this->getCryptographicHash(),
            'length' => $this->getPageCount(),
            'status' => ObjectPublicationStatus::NewStatus
        ));
    }

    private function setThumbnails() {
        $thumbnailsToCreate = ['small', 'large'];

        foreach ($thumbnailsToCreate as $size) {
            $lengthDimension = ($size == 'small') ? $this->smallThumbnailSize : $this->largeThumbnailSize;

            // PDFs, One day learn to extract thumbnails for all the other media types too
            if ($this->fileinfo['filetype'] == 'pdf' && $this->fileinfo['mime'] == 'application/pdf') {
                $image = new \Imagick(public_path() . '/' . $this->directory['full'] . $this->fileinfo['filename'] . '[0]');
                // Use PNG because: http://stackoverflow.com/questions/10934456/imagemagick-pdf-to-jpgs-sometimes-results-in-black-background
                $image->setImageFormat('png');
                $image->setBackgroundColor(new \ImagickPixel('white'));
                $image->thumbnailImage($lengthDimension, $lengthDimension, true);
                // http://php.net/manual/en/imagick.flattenimages.php#101164
                $image = $image->flattenImages();
                $image->setImageFormat('jpg');
                $image->writeImage(public_path() . '/' . $this->directory[$size] . $this->fileinfo['filename_without_extension'] . '.jpg');
            }
        }
    }

    private function getThumbnail() {
        if ($this->fileinfo['filetype'] == 'pdf' && $this->fileinfo['mime'] == 'application/pdf') {
            return $this->fileinfo['filename_without_extension'] . '.jpg';
        }
        return null;
    }

    private function getPageCount() {
        $filetype = $this->fileinfo['filetype'];
        $mime = $this->fileinfo['mime'];

        // PDFs only for now
        if ($filetype == 'pdf' && $mime == 'application/pdf') {
            // http://stackoverflow.com/a/9642701/1064923
            $image = new \Imagick(public_path() . '/' . $this->directory['full'] . $this->fileinfo['filename']);
            $image->pingImage(public_path() . '/' . $this->directory['full'] . $this->fileinfo['filename']);
            return $image->getNumberImages() / 2; // I have no idea why this is needed
        }

        return null;
    }
}