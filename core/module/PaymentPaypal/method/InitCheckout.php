<?php
/**
 * Send user to paypal the 1st time to init checkout.
 * @author gizmore
 */
final class PaymentPaypal_InitCheckout extends GWF_Method
{
	public function execute()
	{
		if (false === ($order = GWF_Order::getByToken(Common::getPostString('gwf_token')))) {
			return $this->module->error('err_order');
		}
		if (!$order->isCreated()) {
			return $this->module->error('err_order');
		}

		$gdo = $order->getOrderData();
		$user = $order->getOrderUser();# GWF_User::getStaticOrGuest();
		
		/* The servername and serverport tells PayPal where the buyer
		   should be directed back to after authorizing payment.
		   In this case, its the local webserver that is running this script
		   Using the servername and serverport, the return URL is the first
		   portion of the URL that buyers will return to after authorizing payment
		   */

		 /* The returnURL is the location where buyers return when a
			payment has been succesfully authorized.
			The cancelURL is the location buyers are sent to when they hit the
			cancel button during authorization of payment during the PayPal flow
		*/
		$successURL = urlencode($this->get2ndStepURL($order, $gdo));
		$cancelURL = urlencode(Common::getAbsoluteURL($gdo->getOrderCancelURL($user), false));
		$shipping = $gdo->needsShipping($user) ? '0' : '1';
		
		 /* Construct the parameter string that describes the PayPal payment
			the varialbes were set in the web form, and the resulting string
			is stored in $nvpstr
			*/
		$paymentAmount = $order->getOrderPriceTotal(2);
		$paymentType = "Sale";
		$currencyCodeType = $order->getOrderCurrency();
		$nvpstr = "&Amt=$paymentAmount".
		          "&PAYMENTACTION=$paymentType".
		          "&ReturnUrl=$successURL".
		          "&CANCELURL=$cancelURL".
		          "&CURRENCYCODE=$currencyCodeType".
		          "&no_shipping=$shipping".
				  "&LOCALECODE=".strtoupper(GWF_Language::getCurrentISO());
//		var_dump($nvpstr);
		
		 /* Make the call to PayPal to set the Express Checkout token
			If the API call succeded, then redirect the buyer to PayPal
			to begin to authorize payment.  If an error occured, show the
			resulting errors
			*/
		$resArray = Paypal_Util::hash_call('SetExpressCheckout', $nvpstr);
//		var_dump($resArray);

		$ack = strtoupper($resArray["ACK"]);
		if($ack=="SUCCESS")
		{
			// Redirect to paypal.com here
			$token = urldecode($resArray["TOKEN"]);
			if (false === ($order->saveVar('order_xtoken', $token))) {
				return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
			}
			$payPalURL = PAYPAL_URL.$token;
			header("Location: ".$payPalURL);
			echo 'The browser should redirect you to: '.$payPalURL.PHP_EOL;
			die();
		}
		else {
			return Paypal_Util::paypalError($resArray);
		}
	}
	
	private function get2ndStepURL(GWF_Order $order, GWF_Orderable $gdo)
	{
		return Common::getAbsoluteURL('index.php?mo=PaymentPaypal&me=ConfirmCheckout&gwf_token='.$order->getOrderToken());
//		return 'i_paid_with_paypal_for/'.$order->escape('order_title').'/'.$order->getOrderToken();
	}
}

?>