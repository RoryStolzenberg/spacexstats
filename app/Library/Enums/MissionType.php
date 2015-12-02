<?php

namespace SpaceXStats\Library\Enums;


class MissionType extends Enum
{
    const DragonISS = "Dragon (ISS)";
    const CrewDragonISS = "Crew Dragon (ISS)";
    const DragonFreeflight = "Dragon (Freeflight)";
    const CommunicationsSatellite = "Communications Satellite";
    const ConstellationMission = "Constellation Mission";
    const SpaceXConstellationMission = "SpaceX Constellation Mission";
    const DemoFlight = "Demo Flight";
    const Military = "Military";
    const Scientific = "Scientific";
    const Mars = "Mars";
    const Rideshare = "Rideshare";
}