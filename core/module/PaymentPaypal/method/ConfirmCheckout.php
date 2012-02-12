<?php
/**
 * At this point, the buyer has completed in authorizing payment
 * at PayPal.  The script will now call PayPal with the details
 * of the authorization, incuding any shipping information of the
 * buyer.  Remember, the authorization is not a completed transaction
 * at this state - the buyer still needs an additional step to finalize
 * the transaction.
*/
final class PaymentPaypal_ConfirmCheckout extends GWF_Method
{
	public function execute()
	{
		$gwf_token = Common::getGet('gwf_token');
		if (false === ($order = GWF_Order::getByToken($gwf_token))) {
			return $this->module->error('err_token');
		}
		if (!$order->isCreated()) {
			return $this->module->error('err_order');
		}
		if (false === ($paypaltoken = Common::getGet("token"))) {
			return Module_Payment::instance()->error("err_xtoken", array(GWF_HTML::display($this->module->getSiteName())));
		}
		if ($order->getOrderXToken() !== $paypaltoken) {
			return Module_Payment::instance()->error("err_xtoken", array(GWF_HTML::display($this->module->getSiteName())));
		}
		
		/* Build a second API request to PayPal, using the token as the
			ID to get the details on the payment authorization
		*/
		$nvpstr = "&TOKEN=".urlencode($paypaltoken);

		/* Make the API call and store the results in an array.  If the
			call was a success, show the authorization details, and provide
			an action to complete the payment.  If failed, show the error
		*/
		$resArray = Paypal_Util::hash_call('GetExpressCheckoutDetails', $nvpstr);

		$ack = strtoupper($resArray["ACK"]);
		if($ack=="SUCCESS")
		{
			$order->saveVar('order_xtoken', serialize($resArray));
			$module2 = $order->getOrderModule();
			$module2->onLoadLanguage();
			$gdo = $order->getOrderData();
			$user = $order->getOrderUser();
			$button = $this->module->displayPaysiteButton3($module2, $order, $gdo, $user);
			return Module_Payment::displayOrder3S($module2, $order, $gdo, $user, $order->getOrderPaySite(), $button);
		}
		else {
			return Paypal_Util::paypalError($resArray);
		}
	}
}
?>