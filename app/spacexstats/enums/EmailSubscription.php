<?php
namespace SpaceXStats\Enums;

abstract class EmailSubscription {
    const newMission = 1;
    const updatedMission = 2;
    const tMinus24HoursMission = 3;
}