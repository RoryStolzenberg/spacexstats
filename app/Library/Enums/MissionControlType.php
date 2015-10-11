<?php

namespace SpaceXStats\Library\Enums;

abstract class MissionControlType extends Enum
{
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