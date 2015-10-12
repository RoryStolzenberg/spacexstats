<?php

namespace SpaceXStats\Library\Enums;

abstract class MissionStatus extends Enum
{
    const Complete = 'Complete';
    const InProgress = 'In Progress';
    const Upcoming = 'Upcoming';
}