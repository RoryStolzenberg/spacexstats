<?php

namespace SpaceXStats\Library\Enums;

abstract class MissionStatus extends Enum
{
    const Complete = 'Complete';
    const InProgress = 'InProgress';
    const Upcoming = 'Upcoming';
}