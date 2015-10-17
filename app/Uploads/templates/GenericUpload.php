<?php
namespace SpaceXStats\Uploads\Templates;

abstract class GenericUpload {
	protected $file,
	$fileinfo,
	$uniqid,
    $smallThumbnailSize = 200,
    $largeThumbnailSize = 800,
	$directory = array(
        'full' => 'media/full/',
        'large' => 'media/large/',
        'small' => 'media/small/',
        'twitter' => 'media/twitter/',
        'frames' => 'media/frames/'
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
}