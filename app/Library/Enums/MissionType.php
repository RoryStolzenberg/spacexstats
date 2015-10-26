<?php

namespace SpaceXStats\Library\Enums;


class MissionType extends Enum
{
    const DragonISS = "Dragon (ISS)";
    const DragonFreeflight = "Dragon Freeflight";
    const CommunicationsSatellite = "Communications Satellite";
    const ConstellationMission = "Constellation Mission";
    const SpaceXConstellationMission = "SpaceX Constellation Mission";
    const Expirimental = "Experimental";
    const DemoFlight = "Demo Flight";
    const Military = "Military";
    const Scientific = "Scientific";
}