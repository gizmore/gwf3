<?php

final class Black_Friday_Form
{
	public function form()
	{
		$data = array();
		$data['url'] = array(GWF_Form::STRING, '', 'HTTP URL');
		$data['satisfy'] = array(GWF_Form::SUBMIT, 'satisfy');
		return new GWF_Form($this, $data);
	}
	
	public function execute($url, $accepted)
	{
		$response = self::post($url);
		$code = Common::substrUntil($response, "\n");
		if (Common::startsWith($code, $accepted))
		{
			return true;
		}
		else
		{
			if ($code)
			{
				echo GWF_HTML::error('Friday', $code);
			}
		}
	}

	public static function post($url)
	{
		# Clean URL
		if (false === ($parts = parse_url($url)))
		{
			return false;
		}
		
		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_PROTOCOLS, CURLPROTO_HTTP|CURLPROTO_HTTPS);
		
		curl_setopt($ch, CURLOPT_COOKIEFILE, "");
		
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		if (isset($parts['scheme']) && ($parts['scheme'] === 'https'))
		{
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($ch, CURLOPT_SSLVERSION, 1);
		}
		curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'BUNNY');
		curl_setopt($ch, CURLOPT_USERAGENT, GWF_HTTP::USERAGENT);
		
		if (false === ($received = curl_exec($ch)))
		{
			echo GWF_HTML::error('GWF_HTTP', curl_errno($ch).' - '.curl_error($ch));
		}
		curl_close($ch);
		return $received;
	}

}
