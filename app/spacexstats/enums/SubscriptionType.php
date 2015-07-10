<?php
namespace SpaceXStats\Enums;

abstract class SubscriptionType {
    const NewMission = 1;
    const LaunchTimeChange = 2;
    const TMinus24Hours = 3;
    const TMinus3Hours = 4;
    const TMinus1Hour = 5;
    const NewSummaries = 6;
}