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

			case 11: return 'Post';

			case 12: return 'Pivot';
			case 13: return 'Person';

            default: return null;
		}
	}
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

    public static function getType($num) {
        switch ($num) {
            case 1: return 'Mission Patch';
            case 2: return 'Photo';
            case 3: return 'Telemetry';
            case 4: return 'Chart';
            case 5: return 'Screenshot';
            case 6: return 'Launch Video';
            case 7: return 'Press Conference';
            case 8: return 'Press Kit';
            case 9: return 'Cargo Manifest';
            case 10: return 'Infographic';
            case 11: return 'News Summary';
            case 12: return 'Press Release';
            case 13: return 'Reddit Comment';
            case 14: return 'NSF Comment';
            case 15: return 'Weather Forecast';
            case 16: return 'Hazard Map';
            case 17: return 'License';

            default: return null;
        }
    }
}