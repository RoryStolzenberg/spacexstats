<?php

namespace SpaceXStats\Library\Enums;

abstract class Destination extends Enum
{
    const LowEarthOrbit = 'Low Earth Orbit';
    const LowEarthOrbitISS = 'Low Earth Orbit (ISS)';
    const PolarOrbit = "Polar Orbit";
    const SunSynchronousOrbit = "Sun Synchronous Orbit";
    const MediumEarthOrbit = 'Medium Earth Orbit';
    const GeostationaryTransferOrbit = 'Geostationary Transfer Orbit';
    const SubsynchronousGTO = "Subsynchronous GTO";
    const SupersynchronousGTO = "Supersynchronous GTO";
    const HighEarthOrbit = "High Earth Orbit";
    const EarthSunL1 = "Earth-Sun L1";
    const Lunar = "Lunar";
    const Mars = "Mars";
    const Suborbital = "Suborbital";
}