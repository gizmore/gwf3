<?php
define("PAYPAL_ERROR_INSUFFICIENT_FUNDS", 10321);

/**
 * Paypal Helper Class
 * @author gizmore
 */
final class Paypal_Util
{
	public static function hash_call($methodName, $nvpStr)
	{
		//declaring of global variables
		#global $API_Endpoint,$version,$API_UserName,$API_Password,$API_Signature,$nvp_Header;
	
		//setting the curl parameters.
//		var_dump(PAYPAL_API_ENDPOINT);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, PAYPAL_API_ENDPOINT);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
	
		//turning off the server and peer verification(TrustManager Concept).
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
	
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_POST, 1);
	    //if USE_PROXY constant set to TRUE in Constants.php, then only proxy will be enabled.
	   //Set proxy name to PROXY_HOST and port number to PROXY_PORT in constants.php 
		if(PAYPAL_USE_PROXY) {
			curl_setopt ($ch, CURLOPT_PROXY, PAYPAL_PROXY_HOST.":".PAYPAL_PROXY_PORT); 
		}
	
		//NVPRequest for submitting to server
		$nvpreq = "METHOD=".urlencode($methodName)."&VERSION=".urlencode(PAYPAL_VERSION)."&PWD=".urlencode(PAYPAL_API_PASSWORD)."&USER=".urlencode(PAYPAL_API_USERNAME)."&SIGNATURE=".urlencode(PAYPAL_API_SIGNATURE).$nvpStr;
		
//		var_dump($nvpreq);
	
		//setting the nvpreq as POST FIELD to curl
		curl_setopt($ch,CURLOPT_POSTFIELDS,$nvpreq);
	
		//getting response from server
		$response = curl_exec($ch);
	
		//convrting NVPResponse to an Associative Array
		$nvpResArray = self::deformatNVP($response);
		$nvpReqArray = self::deformatNVP($nvpreq);

		if (curl_errno($ch)) {
//			echo curl_error($ch);
			return false;
		} else {
			//closing the curl
			curl_close($ch);
		}
		return $nvpResArray;
	}
	
	/** This function will take NVPString and convert it to an Associative Array and it will decode the response.
	  * It is usefull to search for a particular key and displaying arrays.
	  * @nvpstr is NVPString.
	  * @nvpArray is Associative Array.
	  */
	
	public static function deformatNVP($nvpstr) {
	
		$intial=0;
	 	$nvpArray = array();
	
		while(strlen($nvpstr)) {
			
			//postion of Key
			$keypos= strpos($nvpstr,'=');
			//position of value
			$valuepos = strpos($nvpstr,'&') ? strpos($nvpstr,'&'): strlen($nvpstr);
	
			/*getting the Key and Value values and storing in a Associative Array*/
			$keyval = substr($nvpstr,$intial,$keypos);
			$valval = substr($nvpstr,$keypos+1,$valuepos-$keypos-1);
			//decoding the respose
			$nvpArray[urldecode($keyval)] = urldecode( $valval);
			$nvpstr = substr($nvpstr,$valuepos+1,strlen($nvpstr));
			
	     }
	     
		return $nvpArray;
		
	}
	
	public static function paypalError($resArray)
	{
		$back = "PayPal Error: <br><br>";
		$count=0;
		while (isset($resArray["L_SHORTMESSAGE".$count]))
		{
			$errorCode    = $resArray["L_ERRORCODE".$count];
			$shortMessage = $resArray["L_SHORTMESSAGE".$count];
			$longMessage  = $resArray["L_LONGMESSAGE".$count]; 
			$count++;
			
			$back .= "$errorCode: $shortMessage<br>".
				" - $longMessage<br><br>";
		}
		return GWF_HTML::error('PayPal', $back, true);
	}
	
	public static function checkPaypalErrorCode($code)
	{
		$count=0;
		while (isset($resArray["L_SHORTMESSAGE".$count]))
		{
			if ($resArray["L_ERRORCODE".$count] == $code) {
				return true;
			}
		}
		return false;
	}
	
	public static function logResArray(array $resArray)
	{
		$msg = 'PaypalResponse:'.PHP_EOL;
		foreach ($resArray as $k => $v)
		{
			$msg .= "$k => $v\n";
		}
		GWF_Log::log('paypal', $msg);
	}
}

?>
