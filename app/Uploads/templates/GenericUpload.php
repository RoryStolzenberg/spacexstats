<?php
namespace SpaceXStats\Uploads\Templates;

use Imagick;

abstract class GenericUpload {
	protected $file,
	$fileinfo,
	$uniqid,
    $smallThumbnailSize = 200,
    $largeThumbnailSize = 800,
	$directory = array(
        'full' => 'media/temporary/full/',
        'large' => 'media/temporary/large/',
        'small' => 'media/temporary/small/',
        'twitter' => 'media/temporary/twitter/',
        'frames' => 'media/temporary/frames/'
    );

	public function __construct($file) {
		$this->file = $file;

		// Get all the file info
		$this->fileinfo['mime'] = $file->getMimeType();
		$this->fileinfo['size'] = $file->getClientSize();
		$this->fileinfo['filetype'] = $file->getClientOriginalExtension();
		$this->fileinfo['original_name'] = $file->getClientOriginalName();
        $this->fileinfo['filename_without_extension'] = uniqid(\Auth::id(), true);
		$this->fileinfo['filename'] = $this->fileinfo['filename_without_extension'] . '.' . $file->getClientOriginalExtension();

		// move the file
		$this->move();	
	}

    protected function getCryptographicHash() {
        return hash_file('sha256', public_path() . '/' . $this->directory['full'] . $this->fileinfo['filename']);
    }

    private function move() {
		return $this->file->move(public_path() . '/' . $this->directory['full'], $this->fileinfo['filename']);
	}

    protected function createSmallThumbnail() {
        $this->createThumbnail('small');
    }

    protected function createLargeThumbnail() {
        $this->createThumbnail('large');
    }

    private function createThumbnail($thumbnailType) {
        // Check if the directory exists, if not, create
        create_if_does_not_exist(public_path($this->directory[$thumbnailType]));

        // Open the file
        $image = new Imagick(public_path($this->directory['full'] . $this->fileinfo['filename']));

        // Set the thumbnail size
        $image->thumbnailImage($this->{$thumbnailType . 'ThumbnailSize'}, $this->{$thumbnailType . 'ThumbnailSize'}, true);

        // Create the relevant thumbnail
        $image->writeImage(public_path($this->directory[$thumbnailType] . $this->fileinfo['filename']));
    }
}