<?php
namespace SpaceXStats\Uploads\Templates;

use SpaceXStats\Library\Enums\MissionControlType;
use SpaceXStats\Library\Enums\ObjectPublicationStatus;
use SpaceXStats\Exif\Exif;

class ImageUpload extends GenericUpload implements UploadInterface {
	protected $exif;

    public function __construct($file) {
        parent::__construct($file);
        $this->exif = Exif::create($this->directory['full'] . $this->fileinfo['filename']);
    }

	// Add the image to mission control after being uploaded
	public function addToMissionControl() {
        $this->setThumbnails();

		return \Object::create(array(
			'user_id' => \Auth::id(),
			'type' => MissionControlType::Image,
			'size' => $this->fileinfo['size'],
			'filetype' => $this->fileinfo['filetype'],
			'mimetype' => $this->fileinfo['mime'],
			'original_name' => $this->fileinfo['original_name'],
			'filename' => $this->fileinfo['filename'],
            'thumb_filename' => $this->fileinfo['filename'],
            'cryptographic_hash' => $this->getCryptographicHash(),
			'dimension_width' => $this->getDimensions('width'),
			'dimension_height' => $this->getDimensions('height'),
			'coord_lat' => $this->exif->latitude(),
			'coord_lng' => $this->exif->longitude(),
            'camera_manufacturer' => $this->exif->cameraMake(),
            'camera_model' => $this->exif->cameraModel(),
            'exposure' => $this->exif->exposure(),
            'aperture' => $this->exif->aperture(),
            'ISO' => $this->exif->iso(),
            'originated_at' => $this->exif->datetime(),
			'status' => ObjectPublicationStatus::NewStatus
		));
	}

    // Create a thumbnail using Imagick, with sizes determined in the object, and then write it to the appropriate size directory
    private function setThumbnails() {
        $thumbnailsToCreate = ['small', 'large'];

        foreach ($thumbnailsToCreate as $size) {
            $lengthDimension = ($size == 'small') ? $this->smallThumbnailSize : $this->largeThumbnailSize;

            // create an Imagick instance
            $image = new \Imagick($this->getImagickSafeDirectory('full') . $this->fileinfo['filename']);
            $image->thumbnailImage($lengthDimension, $lengthDimension, true);
            $image->writeImage($this->getImagickSafeDirectory($size) . $this->fileinfo['filename']);
        }
    }

	// get the dimensions of an image
	private function getDimensions($dimension) {
		$image = new \Imagick($this->getImagickSafeDirectory('full') . $this->fileinfo['filename']);
		return ($dimension == 'width') ? $image->getImageWidth() : $image->getImageHeight();
	}
}