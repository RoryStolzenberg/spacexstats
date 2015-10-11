<?php

namespace SpaceXStats\Library\Enums;

abstract class ObjectPublicationStatus extends Enum {
    const NewStatus = 'New';
    const QueuedStatus = 'Queued';
    const PublishedStatus = 'Published';
}