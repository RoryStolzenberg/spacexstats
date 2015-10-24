<?php
namespace SpaceXStats\Models\Traits;

use AWS;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use SpaceXStats\Library\Enums\VisibilityStatus;

/**
 * Class UploadableTrait
 * @package SpaceXStats\Models\Traits
 */
trait UploadableTrait {
    /**
     * Checks whether the object has a file or not.
     *
     * This function does not care about the file's location, the object's status, or its visibility.
     *
     * @return bool
     */
    public function hasFile() {
        return $this->has_temporary_file || $this->has_local_file || $this->has_cloud_file;
    }

    /**
     * Checks whether the object has custom thumbnails or not.
     *
     * This function does not care about the thumb's location, the object's status, or its visibility.
     * If a file has a generic thumbnail (such as a "document" thumb), this function will return false.
     *
     * @return bool
     */
    public function hasThumbs() {
        return $this->has_temporary_thumbs || $this->has_local_thumbs || $this->has_cloud_thumbs;
    }

    /**
     * Checks whether the object's file is located in the cloud or not.
     *
     * This function does not check thumbnails.
     *
     * @return bool
     */
    public function hasCloudFile() {
        return $this->has_cloud_file;
    }

    /**
     * Checks whether the object has a copy of the full file stored locally.
     *
     * This function does not care about thumbnails, the object's status or its visibility.
     *
     * @return bool
     */
    public function hasLocalFile() {
        return $this->has_local_file;
    }

    public function hasTemporaryFile() {
        return $this->has_temporary_file;
    }

    /**
     * @return mixed
     */
    public function hasCloudThumbs() {
        return $this->has_cloud_thumbs;
    }

    /**
     * Checks whether the object has its own unique thumbnail or not.
     *
     * This function will return false if the object has a generic thumbnail or does not have a thumbnail. It does
     * not care about the thumbnail's location, the object's status, or its visibility.
     *
     * @return bool
     */
    public function hasLocalThumbs() {
        $defaultThumbs = array("audio.png", "document.png", "text.png", "comment.png", "article.png", "pressrelease.png", "tweet.png");
        return $this->has_local_thumbs && !in_array($this->thumb_filename, $defaultThumbs);
    }

    public function hasTemporaryThumbs() {
        return $this->has_temporary_file;
    }

    /**
     *  Uploads the objects file and thumbnails, if they exist, to Amazon S3 from the temporary storage location.
     *  Does not delete any temporary files, call deleteFromTemporary() for this.
     */
    public function putToCloud() {
        $s3 = AWS::createClient('s3');

        if ($this->hasFile()) {
            $s3->putObject([
                'Bucket' => Config::get('filesystems.disks.s3.bucket'),
                'Key' => $this->filename,
                'Body' => public_path() . $this->media,
                'ACL' =>  $this->visibility === VisibilityStatus::PublicStatus ? 'public-read' : 'private',
            ]);
            $this->has_cloud_file = true;
        }

        if ($this->hasThumbs()) {
            $s3->putObject([
                'Bucket' => Config::get('filesystems.disks.s3.bucketLargeThumbs'),
                'Key' => $this->thumb_filename,
                'Body' => public_path() . $this->media_thumb_large,
                'ACL' => $this->visibility === VisibilityStatus::PublicStatus ? 'public-read' : 'private',
                'StorageClass' => 'REDUCED_REDUNDANCY'
            ]);

            $s3->putObject([
                'Bucket' => Config::get('filesystems.disks.s3.bucketSmallThumbs'),
                'Key' => $this->thumb_filename,
                'Body' => public_path() . $this->media_thumb_small,
                'ACL' => 'public-read',
                'StorageClass' => 'REDUCED_REDUNDANCY'
            ]);
            $this->has_cloud_thumbs = true;
        }
    }

    /**
     * Deletes all files, including thumbnails, from S3, if they exist.
     */
    public function deleteFromCloud() {
        $s3 = AWS::createClient('s3');

        if ($this->hasCloudFile()) {
            $s3->deleteObject(Config::get('filesystems.disks.s3.bucket'), $this->filename);
        }

        if ($this->hasCloudThumbs()) {
            $s3->deleteObject(Config::get('filesystems.disks.s3.bucketLargeThumbs'), $this->thumb_filename);
            $s3->deleteObject(Config::get('filesystems.disks.s3.bucketSmallThumbs'), $this->thumb_filename);
        }

        $this->has_cloud_file = false;
        $this->has_cloud_thumbs = false;
    }

    /**
     * Makes a local copy of a file and thumbs for an object, preferentially fetching from the temporary storage
     * before trying to fetch from S3. Does not delete any temporary files if they exist,
     * call deleteFromTemporary() for this.
     */
    public function putToLocal() {

        $s3 = AWS::createClient('s3');

        if ($this->hasFile()) {
            if ($this->hasTemporaryFile()) {

            } else if ($this->hasCloudFile()) {
                $s3->getObject(array(
                    'Bucket'    => Config::get('filesystems.disks.s3.bucket'),
                    'Key'       => $this->filename,
                    'SaveAs'    => public_path() . '/media/local/' . $this->filename
                ));
            }
            $this->has_local_file = true;
        }

        if ($this->hasThumbs()) {
            if ($this->hasTemporaryThumbs()) {

            } else if ($this->hasCloudThumbs()) {
                $s3->getObject(array(
                    'Bucket'    => Config::get('filesystems.disks.s3.bucketLargeThumbs'),
                    'Key'       => $this->thumb_filename,
                    'SaveAs'    => public_path() . '/media/local/large/' . $this->filename
                ));

                $s3->getObject(array(
                    'Bucket'    => Config::get('filesystems.disks.s3.bucketSmallThumbs'),
                    'Key'       => $this->thumb_filename,
                    'SaveAs'    => public_path() . '/media/local/small/' . $this->filename
                ));
            }
            $this->has_local_thumbs = true;
        }
    }

    /**
     * Deletes the current local file and any thumbs from the local storage.
     */
    public function deleteFromLocal() {
        if ($this->hasLocalFile()) {
            unlink(public_path() . '/media/local/full/' . $this->filename);
            $this->has_local_file = false;
        }

        if ($this->hasLocalThumbs()) {
            unlink(public_path() . '/media/local/small/' . $this->thumb_filename);
            unlink(public_path() . '/media/local/large/' . $this->thumb_filename);
            $this->has_local_thumbs = false;
        }
    }

    /**
     *
     */
    public function deleteFromTemporary() {
        if ($this->hasTemporaryFile()) {
            unlink(public_path() . '/media/temporary/full/' . $this->filename);
            $this->has_temporary_file = false;
        }

        if ($this->hasTemporaryThumbs()) {
            unlink(public_path() . '/media/temporary/small/' . $this->thumb_filename);
            unlink(public_path() . '/media/temporary/large/' . $this->thumb_filename);
            $this->has_temporary_thumbs = false;
        }
    }
}