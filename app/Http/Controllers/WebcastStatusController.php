<?php 
 namespace SpaceXStats\Http\Controllers;

use Illuminate\Support\Facades\Redis;

class WebcastStatusController extends Controller {

	// AJAX GET
	public function getStatus() {
		// Check if the redis values exist
		try {
			//if (Redis::exists('webcast:isLive') == 1 && Redis::exists('webcast:viewers') == 1) {
				return response()->json(Redis::hgetall('webcast'));
			//} else {
			//	return response()->json(array('isLive' => null, 'viewers' => null));
			//}
		} catch (Predis\Connection\ConnectionException $e) {
			return response()->json(['isLive' => null, 'viewers' => null]);
		}
		
	}
}