<?php
namespace SpaceXStats\Http\Controllers\Payment;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use SpaceXStats\Http\Controllers\Controller;
use SpaceXStats\Services\SubscriptionService;

class PaymentController extends Controller {
    public function subscribe(SubscriptionService $subscriptionService) {
        // Retrieve the card token
        $creditCardToken = Input::get('creditCardToken');

        // Create Subscription
        $subscriptionService->createSubscription($creditCardToken);

        // Respond
        return response()->json(null, 204);
    }
}