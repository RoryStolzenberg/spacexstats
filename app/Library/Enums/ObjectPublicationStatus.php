<?php

namespace SpaceXStats\Library\Enums;

abstract class ObjectPublicationStatus extends Enum {
    /**
     * An object will have a publication status of 'New' when it has just been uploaded and the user is still
     * entering information about it. We do not show these items in search results, nor are they visible. If an
     * object retains a 'new' status for more than 7 days we assume it was abandoned and it is deleted via the
     * DeleteOrphanedFilesCommand.
     */
    const NewStatus = 'New';

    /**
     * An object has a queued status when it has been uploaded and information has been entered, but it has not been
     * reviewed by either a moderator or administrator. During this time it is visible to other users, but is only uploaded
     * locally to the SpaceXStats webserver.
     */
    const QueuedStatus = 'Queued';

    /**
     * An object is considered published when it has been independently reviewed by either a moderator or administrator,
     * and is uploaded to Amazon S3 - it can no longer be deleted. A local file may be retained to reduce Amazon S3 costs.
     */
    const PublishedStatus = 'Published';
}