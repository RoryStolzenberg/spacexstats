<?php
namespace SpaceXStats\Models\Interfaces;

interface UploadableInterface extends HasFilesInterface {
	public function hasCloudFile();

	public function hasLocalFile();

	public function hasCloudThumbs();

	public function hasLocalThumbs();

	public function putToCloud();

	public function deleteFromCloud();

	public function putToLocal();

	public function deleteFromLocal();
}