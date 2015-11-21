<?php
namespace SpaceXStats\Library\Enums;

abstract class NotificationType extends Enum {
    const NewMission = 1;
    const LaunchChange = 2;
    const TMinus24HoursEmail = 3;
    const TMinus3HoursEmail = 4;
    const TMinus1HourEmail = 5;
    const NewsSummaries = 6;
    const TMinus24HoursSMS = 7;
    const TMinus3HoursSMS = 8;
    const TMinus1HourSMS = 9;

    const Deorbit = 10;
}