<?php
namespace SpaceXStats\Uploads\Templates;

use Imagick;
use SpaceXStats\Library\Enums\DateSpecificity;
use SpaceXStats\Library\Enums\MissionControlType;
use SpaceXStats\Library\Enums\ObjectPublicationStatus;
use SpaceXStats\Library\Exif\Exif;
use SpaceXStats\Models\Object;

class ImageUpload extends GenericUpload implements UploadInterface {
	protected $exif;

    public function __construct($file) {
        parent::__construct($file);
        $this->exif = Exif::create($this->directory['full'] . $this->fileinfo['filename']);
    }

	// Add the image to mission control after being uploaded
	public function addToMissionControl() {
        $this->setThumbnails();

		return Object::create(array(
			'user_id' => \Auth::id(),
			'type' => MissionControlType::Image,
			'size' => $this->fileinfo['size'],
			'filetype' => $this->fileinfo['filetype'],
			'mimetype' => $this->fileinfo['mime'],
			'original_name' => $this->fileinfo['original_name'],
			'filename' => $this->fileinfo['filename'],
            'thumb_filename' => $this->fileinfo['filename'],
            'has_temporary_file' => true,
            'has_temporary_thumbs' => true,
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
            'originated_at_specificity' => !is_null($this->exif->datetime()) ? DateSpecificity::Datetime : null,
			'status' => ObjectPublicationStatus::NewStatus
		));
	}

    private function setThumbnails() {
        $this->createSmallThumbnail();
        $this->createLargeThumbnail();
    }

	// get the dimensions of an image
	private function getDimensions($dimension) {
		$image = new Imagick(public_path() . '/' . $this->directory['full'] . $this->fileinfo['filename']);
		return ($dimension == 'width') ? $image->getImageWidth() : $image->getImageHeight();
	}
}