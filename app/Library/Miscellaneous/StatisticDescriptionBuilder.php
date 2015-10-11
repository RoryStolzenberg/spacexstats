<?php
namespace SpaceXStats\Library\Miscellaneous;

use SpaceXStats\Models\Mission;

class StatisticDescriptionBuilder {
    public static function nextLaunch($substatistic, $dynamicString) {
        if ($dynamicString === 'nextLaunchSummary') {
            return Mission::future(1)->first()->summary;
        }
    }
}