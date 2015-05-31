<?php

class WebcastStatusController extends BaseController {

	// AJAX POST
	public function getStatus() {
		// Check if the redis values exist
		try {
			//if (Redis::exists('webcast:isLive') == 1 && Redis::exists('webcast:viewers') == 1) {
				return Response::json(array('isLive' => Redis::hget('webcast', 'isLive'), 'viewers' => Redis::hget('webcast', 'viewers')));
			//} else {
			//	return Response::json(array('isLive' => null, 'viewers' => null));
			//}
		} catch (Predis\Connection\ConnectionException $e) {
			return Response::json(array('isLive' => null, 'viewers' => null));
		}
		
	}
}