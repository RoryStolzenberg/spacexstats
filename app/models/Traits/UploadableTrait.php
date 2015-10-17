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
        return $this->has_temporary_file || $this->has_local_file || $this->has_cloud_file;
    }

    public function hasThumbs() {
        return $this->has_temporary_thumbs || $this->has_local_thumbs || $this->has_cloud_thumbs;
    }

    /**
     *
     */
    public function hasCloudFile() {
        // Check if a file exists in S3 for this object
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
        return !$this->has_local_thumbs && !in_array($this->thumb_filename, $defaultThumbs);
    }

    public function hasCloudThumbs() {
        return $this->hasCloudThumbs;
    }

    /**
     *  Uploads the objects file and thumbnails, if they exist, to Amazon S3, and then unsets the temporary file.
     */
    public function putToCloud() {
        $s3 = AWS::createClient('s3');

        if ($this->hasFile()) {
            $s3->putObject([
                'Bucket' => Config::get('filesystems.disks.s3.bucket'),
                'Key' => $this->filename,
                'Body' => fopen(public_path() . $this->media, 'rb'),
                'ACL' =>  $this->visibility === VisibilityStatus::PublicStatus ? 'public-read' : 'private',
            ]);
            unlink(public_path() . $this->media);
        }

        if ($this->hasThumbs()) {
            $s3->putObject([
                'Bucket' => Config::get('filesystems.disks.s3.bucketLargeThumbs'),
                'Key' => $this->thumb_filename,
                'Body' => fopen(public_path() . $this->media_thumb_large, 'rb'),
                'ACL' =>  $this->visibility === VisibilityStatus::PublicStatus ? 'public-read' : 'private',
                'StorageClass' => 'REDUCED_REDUNANCY'
            ]);
            unlink(public_path() . $this->media_thumb_large);

            $s3->putObject([
                'Bucket' => Config::get('filesystems.disks.s3.bucketSmallThumbs'),
                'Key' => $this->thumb_filename,
                'Body' => fopen(public_path() . $this->media_thumb_small, 'rb'),
                'ACL' => 'public-read',
                'StorageClass' => 'REDUCED_REDUNANCY'
            ]);
            unlink(public_path() . $this->media_thumb_small);
        }
    }

    /**
     * Deletes all files, including thumbnails, from S3, if they exist.
     */
    public function deleteFromCloud() {
        $s3 = AWS::createClient('s3');

        if ($this->hasFile()) {
            if ($this->status === ObjectPublicationStatus::PublishedStatus) {
                $s3->deleteObject(Config::get('filesystems.disks.s3.bucket'), $this->filename);
            }
        }

        if ($this->hasThumbs()) {
            if ($this->status === ObjectPublicationStatus::PublishedStatus) {
                $s3->deleteObject(Config::get('filesystems.disks.s3.bucketLargeThumbs'), $this->filename);
                $s3->deleteObject(Config::get('filesystems.disks.s3.bucketSmallThumbs'), $this->filename);
            }
        }

        $this->has_cloud_file = false;
        $this->has_cloud_thumbs = false;
        $this->save();
    }

    /**
     * Makes a local copy of a file of an object from S3.
     *
     * The function does not currently support the creation of local files from temporary files.
     */
    public function putToLocal() {
        if (!$this->hasLocalFile()) {
            if ($this->hasFile()) {
                AWS::createClient('s3')->getObject(array(
                    'Bucket'    => Config::get('filesystems.disks.s3.bucket'),
                    'Key'       => $this->filename,
                    'SaveAs'    => public_path() . '/media/local/' . $this->filename
                ));

                $this->has_local_file = true;
                $this->save();
            }
        }
    }

    /**
     * Deletes the current local file.
     *
     * Only deletes the main file.
     */
    public function deleteFromLocal() {
        if ($this->hasLocalFile()) {
            unlink(public_path() . $this->filename);
            $this->has_local_file = false;
            $this->save();
        }
    }
}