<?php

namespace SpaceXStats\Enums;

abstract class Status extends Enum {
    const NewStatus = 'New';
    const QueuedStatus = 'Queued';
    const PublishedStatus = 'Published';
}