<?php
namespace SpaceXStats\UploadTemplates;

abstract class GenericUpload {
	protected $file,
	$fileinfo,
	$uniqid,
	$directory = array('full' => 'media/full/','large' => 'media/large/' ,'small' => 'media/small/'),
    $workingDirectory = 'H:/spacexstats/public/';

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

    /**
     * Gets the safe working directory of the file for Imagick processing.
     *
     * This is a workaround to bypass Imagick's inability to use relative file paths on Windows OS
     * by prefixing them with a working directory, defined as a property of the GenericUpload class.
     *
     * @param $directoryType
     * @return string
     */
    protected function getImagickSafeDirectory($directoryType) {
        // *nix
        if (DIRECTORY_SEPARATOR === '/') {
            return $this->directory[$directoryType];

        // windows
        } elseif (DIRECTORY_SEPARATOR === '\\') {
            return $this->workingDirectory . $this->directory[$directoryType];
        }

    }


    private function move() {
		return $this->file->move($this->directory['full'], $this->fileinfo['filename']);
	}
}