<?php
namespace SpaceXStats\Enums;

abstract class MissionControlType {
	// Upload
	const Image 		= 1;
	const GIF 			= 2;
	const Audio 		= 3;
	const Video 		= 4;
	const Document 		= 5;

	// Post
	const Tweet 		= 6;
	const Article 		= 7;
	const Transcript	= 8;
	const Comment		= 9;
    const Webpage       = 10;

	// Update
	const Update		= 11;

	// Private 
	const Pivot			= 12;
	const Person 		= 13;

	public static function getType($num) {
		switch ($num) {
			case 1: return 'Image';
			case 2: return 'GIF';
			case 3: return 'Audio';
			case 4: return 'Video';
			case 5: return 'Document';

			case 6: return 'Tweet';
			case 7: return 'Article';
			case 8: return 'Transcript';
			case 9: return 'Comment';
            case 10: return 'Webpage';

			case 11: return 'Update';

			case 12: return 'Pivot';
			case 13: return 'Person';
		}
	}
}

abstract class MissionControlSubtype {
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
    const Map               = 16;
}