<?php
namespace SpaceXStats\Library;

use SpaceXStats\Enums\MissionControlType;
use SpaceXStats\UploadTemplates;

class FileChecker {
	protected static $maxFileSize = 1073741824; // 1GB

	protected static $mimetypes = array(
		'image/jpeg', 'image/pjpeg', 'image/png', 
		'image/gif',
		'video/mp4', 'video/mpeg', 'video/ogg', 
		'application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'text/plain', 'text/rtf', 'application/rtf',
		'audio/mp3', 'audio/mpeg', 'audio/ogg'
	);

	protected static $filetypes = array(
		'jpg', 'jpeg', 'png', // Images
		'gif', // gif
		'mp4', 'ogv', // Video
		'pdf', 'doc', 'docx', 'xls', 'xlsx', 'txt', 'rtf', //  Documents
		'mp3', 'ogg' // Audio
	);

	// Create the file
	public static function create($file) {
		if (self::check($file) === true) {
			$type = self::determineMissionControlType($file);

			switch ($type) {
				case MissionControlType::Image: return new UploadTemplates\ImageUpload($file);
				case MissionControlType::GIF: return new UploadTemplates\GIFUpload($file);
				case MissionControlType::Audio: return new UploadTemplates\AudioUpload($file);
				case MissionControlType::Video: return new UploadTemplates\VideoUpload($file);
				case MissionControlType::Document: return new UploadTemplates\DocumentUpload($file);
			}
		}
	}

	// Get the errors
	public static function errors($file) {
		if ($file->getError() != UPLOAD_ERR_OK || self::otherChecks($file) == false) {
			return array_merge(array($file->getError()), self::otherChecks($file, true));
		} else {
			return false;
		}
	}

	// Check if the file is valid or not
	private static function check($file) {
		return ($file->isValid() === true && self::otherChecks($file) === true);
	}

	private static function otherChecks($file, $returnErrors = false) {
		// Check filesize
		if ($file->getClientSize() > self::$maxFileSize) {
			$errors[] = "UPLOAD_ERR_FORM_SIZE";
		}

		// Check filetype
		if (!in_array(strtolower($file->getClientOriginalExtension()), self::$filetypes)) {
			$errors[] = "UPLOAD_ERR_FILE_TYPE";
		}

		// Check mimetype
		if (!in_array($file->getMimeType(), self::$mimetypes)) {
			$errors[] = "UPLOAD_ERR_MIME_TYPE";
		}

		// Check if there is a mismatch between the filetype and the mimetype
		if (self::determineMissionControlType($file) === false) {
			$errors[] = "UPLOAD_ERR_MISMATCH";
		}

		// If it's an image, check the image dimensions are between 100 & 10000 pixels
		//if (self)
		
		if ($returnErrors && isset($errors)) {
			// return the errors directly
			return $errors;
		} else {
			// returns true/false
			return empty($errors);			
		}
	}

	private static function determineMissionControlType($file) {
		if (in_array(strtolower($file->getClientOriginalExtension()), array('jpeg','jpg','png')) && in_array($file->getMimeType(), array('image/jpeg', 'image/pjpeg', 'image/png'))) {
			return MissionControlType::Image;

		} elseif (in_array(strtolower($file->getClientOriginalExtension()), array('gif')) && in_array($file->getMimeType(), array('image/gif'))) {
			return MissionControlType::GIF; 
		
		} elseif (in_array(strtolower($file->getClientOriginalExtension()), array('mp4', 'ogv')) && in_array($file->getMimeType(), array('video/mp4', 'video/mpeg', 'video/ogg'))) {
			return MissionControlType::Video;

		} elseif (in_array(strtolower($file->getClientOriginalExtension()), array('mp3', 'ogg')) && in_array($file->getMimeType(), array('audio/mp3', 'audio/mpeg', 'audio/ogg'))) {
			return MissionControlType::Audio;

		} elseif (in_array(strtolower($file->getClientOriginalExtension()), array('pdf', 'doc', 'docx', 'xls', 'xlsx', 'txt')) && in_array($file->getMimeType(), array('application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'text/plain'))) {
			return MissionControlType::Document;

		} else {
			return false;
		}		
	}
}