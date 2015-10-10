<?php

namespace SpaceXStats\Enums;

abstract class VisibilityStatus extends Enum {
    const PublicStatus = "Public";
    const DefaultStatus = "Default";
    const HiddenStatus = "Hidden";
}