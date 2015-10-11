<?php
namespace SpaceXStats\Library\Enums;

abstract class MissionControlType extends Enum {
	// Upload
	const Image 		= 1;
	const GIF 			= 2;
	const Audio 		= 3;
	const Video 		= 4;
	const Document 		= 5;
    const Model         = 6;

	// Submission
	const Tweet 		= 7;
	const Article 		= 8;
	const Transcript	= 9;
	const Comment		= 10;
    const Webpage       = 11;

	// Writing
	const Text		    = 12;

	// Private 
	const Pivot			= 13;
	const Person 		= 14;
}

abstract class MissionControlSubtype extends Enum {
	const MissionPatch 		= 1;
	const Photo				= 2;
	const Telemetry 		= 3;
	const Chart 			= 4;
	const Screenshot		= 5;
	const LaunchVideo   	= 6;
	const PressConference	= 7;
	const PressKit 			= 8;
	const CargoManifest		= 9;
	const Infographic		= 10;
	const NewsSummary		= 11;
	const PressRelease 		= 12;
	const RedditComment 	= 13;
	const NSFComment 		= 14;
	const WeatherForecast	= 15;
    const HazardMap         = 16;
    const License           = 17;
}