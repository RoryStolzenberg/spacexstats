<?php
namespace SpaceXStats\Enums;

abstract class MissionControlType extends Enum {
	// Upload
	const Image 		= 1;
	const GIF 			= 2;
	const Audio 		= 3;
	const Video 		= 4;
	const Document 		= 5;

	// Submission
	const Tweet 		= 6;
	const Article 		= 7;
	const Transcript	= 8;
	const Comment		= 9;
    const Webpage       = 10;

	// Writing
	const Text		    = 11;

	// Private 
	const Pivot			= 12;
	const Person 		= 13;
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