<?php

namespace SpaceXStats\Library\Enums;

abstract class MissionControlType extends Enum
{
    // Upload
    const Image 		= "Image";
    const GIF 			= "GIF";
    const Audio 		= "Audio";
    const Video 		= "Video";
    const Document 		= "Document";
    const Model         = "Model";

    // Submission
    const Tweet 		= "Tweet";
    const Article 		= "Article";
    const Transcript	= "Transcript";
    const Comment		= "Comment";
    const Webpage       = "Webpage";

    // Writing
    const Text		    = "Text";

    // Private
    const Person 		= "Person";
}