<?php
namespace SpaceXStats\UploadTemplates;

use GifFrameExtractor\GifFrameExtractor as GifFrameExtractor;
use SpaceXStats\Enums\MissionControlType as MissionControlType;

class GIFUpload extends GenericUpload implements UploadInterface {
	protected
	$smallThumbnailSize = 200, 
	$largeThumbnailSize = 800;

	// Add the image to mission control after being uploaded
    public function addToMissionControl() {
		return \Object::create(array(
			'user_id' => \Auth::id(),
			'type' => MissionControlType::GIF,
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
			'status' => 'new'
		));
	}

    // Create a thumbnail using Imagick, with sizes determined in the object, and then write it to the appropriate size directory
	private function setThumbnail($size) {
		$lengthDimension = ($size == 'small') ? $this->smallThumbnailSize : $this->largeThumbnailSize;
        $gifFilePath = $this->directory['full'] . $this->fileinfo['filename'];

        $gfe = new GifFrameExtractor();
        $gfe->extract($gifFilePath);

        $gifFrames = $gfe->getFrameImages();

        // Grab a frame approximately 10% of the way through the GIF
        $resource = $gifFrames[(int)round(count($gifFrames) / 10)];

        // Convert img GD resource into an image for imagick
        ob_start();
        imagejpeg($resource);
        $blob = ob_get_clean();

        // Turn Gif frame into thumbnail
		$image = new \Imagick();
        $image->readImageBlob($blob);
		$image->thumbnailImage($lengthDimension, $lengthDimension, true);
		$image->writeImage($this->getImagickSafeDirectory($size) . $this->fileinfo['filename_without_extension'] . '.jpg');

		return $this->directory[$size] . $this->fileinfo['filename_without_extension'] . '.jpg';
	}

    private function getDimensions($dimension) {
        $image = new \Imagick($this->getImagickSafeDirectory('full') . $this->fileinfo['filename']);
        return ($dimension == 'width') ? $image->getImageWidth() : $image->getImageHeight();
    }

    private function getCryptographicHash() {
        return hash_file('sha256', $this->directory['full'] . $this->fileinfo['filename']);
    }

    private function getLength() {
        $gifFilePath = $this->directory['full'] . $this->fileinfo['filename'];

        if (GifFrameExtractor::isAnimatedGif($gifFilePath)) {
            $gfe = new GifFrameExtractor();
            $gfe->extract($gifFilePath);

            $gifTotalDuration = 0;

            // Get the total duration of the gif; if a frame is 0/100ths of a second long, automatically add 10/100ths because browsers play it at that speed anyway.
            // Read more: http://humpy77.deviantart.com/journal/Frame-Delay-Times-for-Animated-GIFs-240992090
            foreach ($gfe->getFrameDurations() as $duration) {
                $gifTotalDuration += $duration == 0 ? 10 : $duration;
            }

            return $gifTotalDuration;
        } else {
            // So it's a gif, but it's not animated. Return 0
            return 0;
        }
    }
}