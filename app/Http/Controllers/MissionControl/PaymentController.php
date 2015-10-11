<?php
 namespace SpaceXStats\Http\Controllers;
use Omnipay\Omnipay;

class PaymentController extends Controller {
	public function purchase() {
		$params = array(
			'cancelUrl' => 'http://spacexstatsv4/missioncontrol/buy/cancel',
			'returnUrl' => 'http://spacexstatsv4/missioncontrol/buy/success',
			'name' => 'Mission Control (12 Months)',
			'description' => 'Mission Control (12 Months)',
			'amount' => Credential::PaypalPrice,
			'currency' => 'USD'
		);

		Session::put('purchase',$params);
		Session::save();

		$gateway = Omnipay::create('PayPal_Express');
		$gateway->setUserName(Credential::PaypalUsername);
		$gateway->setPassword(Credential::PaypalPassword);
		$gateway->setSignature(Credential::PaypalSignature);
		$gateway->setNoShipping('1');

		//print_r($gateway->getDefaultParameters());

		// Remove when testing is done!
		$gateway->setTestMode(true);

		$response = $gateway->purchase($params)->send();

		if ($response->isSuccessful()) {
			// payment was successful: update database
			print_r($response);
		} elseif ($response->isRedirect()) {
			// redirect to offsite payment gateway
			$response->redirect();
		} else {
			// payment failed: display message to customer
			echo $response->getMessage();
		}
	}

	public function success() {
		$gateway = Omnipay::create('PayPal_Express');

		$gateway->setUsername(Credential::PaypalUsername);
		$gateway->setPassword(Credential::PaypalPassword);
		$gateway->setSignature(Credential::PaypalSignature);
		$gateway->setTestMode(true);
		$params = Session::get('purchase');

		$response = $gateway->completePurchase($params)->send();
		$paypalResponse = $response->getData(); // this is the raw response object
		if(isset($paypalResponse['PAYMENTINFO_0_ACK']) && $paypalResponse['PAYMENTINFO_0_ACK'] === 'Success') {
			// Response
		} else {
			//Failed transaction
		}
		return View::make('missionControl.buy.success', array(
			'var' => 'someVar',
			'paypalResponse' => $paypalResponse
		));
	}

}