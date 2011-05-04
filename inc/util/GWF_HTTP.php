<?php
/**
 * HTTP functions using curl.
 * @author gizmore
 */
final class GWF_HTTP
{
	public static function pageExists($url)
	{
		if (substr($url, 0, 1)==='/') {
			$url = 'http://'.GWF_DOMAIN.GWF_WEB_ROOT.substr($url, 1);
		}

		// Check URL
//		GWF_Debug::disableErrorHandler();
//		$parts = @parse_url($url);
//		GWF_Debug::enableErrorHandler();
//		if(!$parts) {
//			return false; /* the URL was seriously wrong */
//		}
		if (!GWF_Validator::isValidURL($url)) {
			return false;
		}

		if (false === ($ch = curl_init($url))) {
			return false;
		}

		/* set the user agent - might help, doesn't hurt */
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
 
		/* try to follow redirects */
		@curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
 
		#curl_setopt($ch, CURLOPT_VERBOSE, true);
		

		/* timeout after the specified number of seconds. assuming that this script runs 
		on a server, 20 seconds should be plenty of time to verify a valid URL.  */
  		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
  		curl_setopt($ch, CURLOPT_TIMEOUT, 35);
 
		/* don't download the page, just the header (much faster in this case) */
		curl_setopt($ch, CURLOPT_NOBODY, true);
		curl_setopt($ch, CURLOPT_HEADER, true);
 
		/* handle HTTPS links */
		if(isset($parts['scheme']) && $parts['scheme']=='https') {
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		}
 
		$response = curl_exec($ch);
		curl_close($ch);
		
		/*  get the status code from HTTP headers */
		if(preg_match('/HTTP\/1\.\d+\s+(\d+)/', $response, $matches)){
			$code = intval($matches[1]);
  		} 
  		else {
  			return false;
  		}
 
  		/* see if code indicates success */
  		return (($code>=200) && ($code<400)) || $code == 403;	
	}

	public static function getFromURL($url, $returnHeader=false, $cookie=false)
	{
		$url = trim($url);
		$replace = array(
			" " => "%20",
		);
		$url = str_replace(array_keys($replace), array_values($replace), $url);
		
		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		
		#curl_setopt($ch, CURLOPT_VERBOSE, 1);
		
		if ($cookie !== false) {
			curl_setopt($ch, CURLOPT_COOKIE, $cookie);
		}
		
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)');
		
  		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
  		curl_setopt($ch, CURLOPT_TIMEOUT, 60);
		
 		curl_setopt($ch, CURLOPT_URL, $url);
 		
 		if (is_bool($returnHeader)) {
 			curl_setopt($ch, CURLOPT_HEADER, $returnHeader);
 		}
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		
		/* handle HTTPS links */
		if(Common::startsWith($url, 'https://')) {
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, '0'); # should be 1!
		}
		
		if (false === $received = curl_exec($ch)) {
			echo GWF_HTML::error('GWF_HTTP', curl_errno($ch).' - '.curl_error($ch));
		}
		
		#echo $received;
		
		curl_close($ch);
		return $received;
	}
	
	public static function post($url, $postdata, $returnHeader=false, $httpHeaders=false, $cookie=false)
	{
		if (strlen($url) < 10) {
			return false;
		}
		if (false === ($parts = parse_url($url))) {
			return false;
		}
		$ch = curl_init();
		#curl_setopt($ch, CURLOPT_VERBOSE, true);

		if (is_array($httpHeaders)) {
			curl_setopt($ch, CURLOPT_HTTPHEADER, $httpHeaders);
		}
		
		if ($cookie !== false) {
			curl_setopt($ch, CURLOPT_COOKIE, $cookie);
		}
		
		curl_setopt($ch, CURLOPT_URL, $url);
 		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		if($parts['scheme']=='https')
		{
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		}
		if ($returnHeader === true) {
			curl_setopt($ch, CURLOPT_HEADER, true);
		}
		curl_setopt($ch, CURLOPT_POST, 1);
		
		if (is_array($postdata))
		{
			$data = array();
			foreach ($postdata as $key => $value) {
				$data[] = urlencode($key).'='.urlencode($value);
			}
			$postdata = implode("&", $data);
		}
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
		if (false === ($received = curl_exec($ch))) {
			echo GWF_HTML::error('GWF_HTTP', curl_errno($ch).' - '.curl_error($ch));
		}
		curl_close($ch);
		return $received;		
	}
	
	public static function noCache()
	{
		header('Cache-Control: no-cache, no-store, must-revalidate, pre-check=0, post-check=0, max-age=0');
		#header('Cache-Control: no-cache, no-store, max-age=0, must-revalidate');
		header('Pragma: no-cache');
		header('Expires: 0');
		#header('Cache-Control: no-control, messup-Opera, spontanious-revalidation, redirect-at-will, hidden-execute-malware-mode');
	}
}

?>