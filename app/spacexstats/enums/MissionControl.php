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

			case 11: return 'Text';

			case 12: return 'Pivot';
			case 13: return 'Person';

            default: return null;
		}
	}
}

abstract class MissionControlSubtype extends Enum {
	const MissionPatch 		= 101;
	const Photo				= 102;
	const Telemetry 		= 103;
	const Chart 			= 104;
	const Screenshot		= 105;
	const LaunchVideo   	= 106;
	const PressConference	= 107;
	const PressKit 			= 108;
	const CargoManifest		= 109;
	const Infographic		= 110;
	const NewsSummary		= 111;
	const PressRelease 		= 112;
	const RedditComment 	= 113;
	const NSFComment 		= 114;
	const WeatherForecast	= 115;
    const HazardMap         = 116;
    const License           = 117;

    public static function getType($num) {
        switch ($num) {
            case 101: return 'Mission Patch';
            case 102: return 'Photo';
            case 103: return 'Telemetry';
            case 104: return 'Chart';
            case 105: return 'Screenshot';
            case 106: return 'Launch Video';
            case 107: return 'Press Conference';
            case 108: return 'Press Kit';
            case 109: return 'Cargo Manifest';
            case 110: return 'Infographic';
            case 111: return 'News Summary';
            case 112: return 'Press Release';
            case 113: return 'Reddit Comment';
            case 114: return 'NSF Comment';
            case 115: return 'Weather Forecast';
            case 116: return 'Hazard Map';
            case 117: return 'License';

            default: return null;
        }
    }
}