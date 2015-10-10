<?php

namespace SpaceXStats\Enums;

abstract class EmailStatus extends Enum {
    const Held = "Held";
    const Queued = "Queued";
    const Sent = "Sent";
}