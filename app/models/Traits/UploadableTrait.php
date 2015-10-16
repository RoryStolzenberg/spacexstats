<?php
namespace SpaceXStats\Models\Traits;

use Illuminate\Support\Facades\Config;

trait UploadableTrait {
    /**
     * Checks whether the object has a file or not.
     *
     * This function does not care about the file's location, the object's status, or its visibility.
     *
     * @return bool
     */
    public function hasFile() {
        return !is_null($this->filename);
    }

    public function hasThumbs() {

    }

    /**
     *
     */
    public function hasCloudFile() {
        // Check if a file exists in S3 for this object
    }

    /**
     * Checks whether the object has a copy of the full file stored locally.
     *
     * This function does not care about thumbnails, the object's status or its visibility.
     *
     * @return bool
     */
    public function hasLocalFile() {
        return !is_null($this->local_file);
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
        $defaultThumbs = array("audio.png", "document.png", "text.png", "comment.png", "article.png", "pressrelease.png");
        return !is_null($this->thumb_filename) && !in_array($this->thumb_filename, $defaultThumbs);
    }

    public function hasCloudThumbs() {

    }

    /**
     *  Uploads the objects file and thumbnails, if they exist, to Amazon S3, and then unsets the temporary file.
     */
    public function putToCloud() {
        $s3 = AWS::get('s3');

        if ($this->hasFile()) {
            $s3->putObject([
                'Bucket' => Config::get('filesystems.disks.s3.bucket'),
                'Key' => $this->filename,
                'Body' => fopen(public_path() . $this->media, 'rb'),
                'ACL' =>  $this->visibility === VisibilityStatus::PublicStatus ? \Aws\S3\Enum\CannedAcl::PUBLIC_READ : \Aws\S3\Enum\CannedAcl::PRIVATE_ACCESS,
            ]);
            unlink(public_path() . $this->media);
        }

        if ($this->hasThumbs()) {
            $s3->putObject([
                'Bucket' => Config::get('filesystems.disks.s3.bucketLargeThumbs'),
                'Key' => $this->thumb_filename,
                'Body' => fopen(public_path() . $this->media_thumb_large, 'rb'),
                'ACL' =>  $this->visibility === VisibilityStatus::PublicStatus ? \Aws\S3\Enum\CannedAcl::PUBLIC_READ : \Aws\S3\Enum\CannedAcl::PRIVATE_ACCESS,
                'StorageClass' => \Aws\S3\Enum\StorageClass::REDUCED_REDUNDANCY
            ]);
            unlink(public_path() . $this->media_thumb_large);

            $s3->putObject([
                'Bucket' => Config::get('filesystems.disks.s3.bucketSmallThumbs'),
                'Key' => $this->thumb_filename,
                'Body' => fopen(public_path() . $this->media_thumb_small, 'rb'),
                'ACL' =>  \Aws\S3\Enum\CannedAcl::PUBLIC_READ,
                'StorageClass' => \Aws\S3\Enum\StorageClass::REDUCED_REDUNDANCY
            ]);
            unlink(public_path() . $this->media_thumb_small);
        }
    }

    /**
     * Deletes all files, including thumbnails, from S3, if they exist.
     */
    public function deleteFromCloud() {
        $s3 = AWS::get('s3');

        if ($this->hasFile()) {
            if ($this->status === ObjectPublicationStatus::PublishedStatus) {
                $s3->deleteObject(Credential::AWSS3Bucket, $this->filename);
            }
        }

        if ($this->hasThumbs()) {
            if ($this->status === ObjectPublicationStatus::PublishedStatus) {
                $s3->deleteObject(Config::get('filesystems.disks.s3.bucketLargeThumbs'), $this->filename);
                $s3->deleteObject(Config::get('filesystems.disks.s3.bucketSmallThumbs'), $this->filename);
            }
        }
    }

    /**
     * Makes a local copy of a file of an object from S3.
     *
     * The function does not currently support the creation of local files from temporary files.
     */
    public function putToLocal() {
        if (!$this->hasLocalFile()) {
            if ($this->hasFile()) {
                AWS::get('s3')->getObject(array(
                    'Bucket'    => Config::get('filesystems.disks.s3.bucket'),
                    'Key'       => $this->filename,
                    'SaveAs'    => public_path() . '/media/local/' . $this->filename
                ));

                $this->local_file = '/media/local/' . $this->filename;
                $this->save();
            }
        }
    }

    /**
     * Deletes the current local file.
     */
    public function deleteFromLocal() {
        if ($this->hasLocalFile()) {
            unlink(public_path() . $this->local_file);
            $this->local_file = null;
            $this->save();
        }
    }
}