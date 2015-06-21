<?php
namespace SpaceXStats\Library;

use Carbon\Carbon;

class WebcastChecker {
	private $url = 'http://xspacexx.api.channel.livestream.com/2.0/livestatus.json';

	public function check() {
		$livestream = json_decode(file_get_contents($this->url));

		Redis::hmset('webcast', 'isLive', $livestream->channel->isLive === true ? 'true' : 'false', 'viewers', $livestream->channel->currentViewerCount);

		// Add to Database if livestream is active
		if ($livestream->channel->isLive === true) {
			WebcastStatus::create(array(
				'viewers' => $livestream->channel->currentViewerCount,
				'created_at' => Carbon::now()
			));			
		}
	}
}