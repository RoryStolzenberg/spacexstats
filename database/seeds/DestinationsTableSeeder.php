<?php
use Illuminate\Database\Seeder;
use SpaceXStats\Models\Destination;
use SpaceXStats\Library\Enums\Destination as DestinationEnum;

class DestinationsTableSeeder extends Seeder {
    public function run() {
        Destination::create(array('destination' => DestinationEnum::LowEarthOrbit));
        Destination::create(array('destination' => DestinationEnum::LowEarthOrbitISS));
        Destination::create(array('destination' => DestinationEnum::PolarOrbit));
        Destination::create(array('destination' => DestinationEnum::SunSynchronousOrbit));
        Destination::create(array('destination' => DestinationEnum::MediumEarthOrbit));
        Destination::create(array('destination' => DestinationEnum::GeostationaryTransferOrbit));
        Destination::create(array('destination' => DestinationEnum::SubsynchronousGTO));
        Destination::create(array('destination' => DestinationEnum::SupersynchronousGTO));
        Destination::create(array('destination' => DestinationEnum::HighEarthOrbit));
        Destination::create(array('destination' => DestinationEnum::EarthSunL1));
        Destination::create(array('destination' => DestinationEnum::Lunar));
        Destination::create(array('destination' => DestinationEnum::Mars));
        Destination::create(array('destination' => DestinationEnum::Suborbital));
    }
}