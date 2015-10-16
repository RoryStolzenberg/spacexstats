<?php

namespace SpaceXStats\Library\Enums;

abstract class ObjectPublicationStatus extends Enum {
    const QueuedStatus = 'Queued';
    const PublishedStatus = 'Published';
}