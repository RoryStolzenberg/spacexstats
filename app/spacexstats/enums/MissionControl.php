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
	const Administrator 	= 6;
	const LaunchVideo   	= 7;
	const PressConference	= 8;
	const PressKit 			= 9;
	const CargoManifest		= 10;
	const Infographic		= 11;
	const NewsSummary		= 12;
	const PressRelease 		= 13;
	const RedditComment 	= 14;
	const NSFComment 		= 15;
	const WeatherForecast	= 16;
    const Map               = 17;
}