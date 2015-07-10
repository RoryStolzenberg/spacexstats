<?php
namespace SpaceXStats\Enums;

abstract class NotificationType {
    const NewMission = 1;
    const LaunchTimeChange = 2;
    const TMinus24HoursEmail = 3;
    const TMinus3HoursEmail = 4;
    const TMinus1HourEmail = 5;
    const NewSummaries = 6;
    const TMinus24HoursSMS = 7;
    const TMinus3HoursSMS = 8;
    const TMinus1HourSMS = 9;
}