<?php
namespace SpaceXStats\Uploads\Templates;

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
            'filename' => $this->directory['full'] . $this->fileinfo['filename'],
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

        $lengthDimension = ($size == 'small') ? $this->smallThumbnailSize : $this->largeThumbnailSize;

        // PDFs
        if ($filetype == 'pdf' && $mime == 'application/pdf') {
            $image = new \Imagick($this->getImagickSafeDirectory('full') . $this->fileinfo['filename'] . '[0]');
            // Use PNG because: http://stackoverflow.com/questions/10934456/imagemagick-pdf-to-jpgs-sometimes-results-in-black-background
            $image->setImageFormat('png');
            $image->setBackgroundColor(new \ImagickPixel('white'));
            $image->thumbnailImage($lengthDimension, $lengthDimension, true);
            // http://php.net/manual/en/imagick.flattenimages.php#101164
            $image = $image->flattenImages();
            $image->setImageFormat('jpg');
            $image->writeImage($this->getImagickSafeDirectory($size) . $this->fileinfo['filename_without_extension'] . '.jpg');

            return $this->directory[$size] . $this->fileinfo['filename_without_extension'] . '.jpg';
        }

        // One day learn to extract thumbnails for all the other media types too
        return "media/{$size}/document.png";
    }

    private function getPageCount() {
        $filetype = $this->fileinfo['filetype'];
        $mime = $this->fileinfo['mime'];

        // PDFs only for now
        if ($filetype == 'pdf' && $mime == 'application/pdf') {
            // http://stackoverflow.com/a/9642701/1064923
            $image = new \Imagick($this->getImagickSafeDirectory('full') . $this->fileinfo['filename']);
            $image->pingImage($this->getImagickSafeDirectory('full') . $this->fileinfo['filename']);
            return $image->getNumberImages() / 2; // I have no idea why this is needed
        }

        return null;
    }
}