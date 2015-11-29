<?php
namespace SpaceXStats\Library\Enums;

abstract class MissionControlSubtype extends Enum {
	const MissionPatch 		= "Mission Patch";
	const Photo				= "Photo";
	const Telemetry 		= "Telemetry";
	const Chart 			= "Chart";
	const Screenshot		= "Screenshot";
    const ConceptArt        = "Concept Art";
	const LaunchVideo   	= "Launch Video";
	const PressConference	= "Press Conference";
	const PressKit 			= "Press Kit";
	const CargoManifest		= "Cargo Manifest";
	const Infographic		= "Infographic";
	const NewsSummary		= "News Summary";
	const PressRelease 		= "Press Release";
	const RedditComment 	= "Reddit Comment";
	const NSFComment 		= "NSF Comment";
	const WeatherForecast	= "Weather Forecast";
    const HazardMap         = "Hazard Map";
    const License           = "License";
}