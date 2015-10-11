<?php
namespace SpaceXStats\Library\Enums;

abstract class ExifProperty extends Enum {
	const DateTime 				= 'DateTimeOriginal';
	const CameraManufacturer	= 'Make';
	const CameraModel			= 'Model';

	const Exposure				= 'ExposureTime';
	const Aperture				= 'FNumber';
	const ISO 					= 'ISOSpeedRatings';

	const GPSLatitude 			= 'GPSLatitude';
	const GPSLongitude 			= 'GPSLongitude';
	const GPSAltitude 			= 'GPSAltitude';
}