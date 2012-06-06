<?php
final class GWF_GTranslate
{
	const API_KEY = '';
	const VERSION = '1.0';
	const URL_DETECT = 'http://ajax.googleapis.com/ajax/services/language/detect';
	const URL_TRANSLATE = 'http://ajax.googleapis.com/ajax/services/language/translate';

	public static $LANGUAGES = array(
		'af','sq','ar','hy','az','eu','be','bg','ca','zh-CN',
		'hr','cs','da','nl','en','et','tl','fi','fr','gl',
		'ka','de','el','ht','iw','hi','hu','is','id','ga',
		'it','ja','ko','lv','lt','mk','ms','mt','no','fa',
		'pl','pt','ro','ru','sr','sk','sl','es','sw','sv',
		'th','tr','uk','ur','vi','cy','yi',
	);

	#################
	### Translate ###
	#################
	public static function translate($text, $from='auto', $to='en')
	{
		$to = strtolower(trim($to));
		$from = strtolower(trim($from));
		if ($from === $to)
		{
			return $text;
		}
		if ($text === '')
		{
			return $text;
		}
		if ( (!in_array($from, self::$LANGUAGES, true)) && $from !== 'auto' )
		{
			echo GWF_HTML::err('ERR_GENERAL', array(__FILE__, __LINE__));
			return false;
		}
		if (!in_array($to, self::$LANGUAGES, true)) {
			echo GWF_HTML::err('ERR_GENERAL', array(__FILE__, __LINE__));
			return false;
		}

		if ($from === 'auto')
		{
			$from = '';
		}

		$keyString = '';
		if (self::API_KEY !== '')
		{
			$keyString = '&key='.urlencode(self::API_KEY);
		}
		$postString = sprintf('v=%s%s&q=%s&langpair=%s|%s&userip=%s', self::VERSION, $keyString, urlencode($text), $from, $to, $_SERVER['REMOTE_ADDR']);
		return self::parseResponse(self::curlRequest($postString, self::URL_TRANSLATE));
	}

	private static function curlRequest($postString, $url)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//		curl_setopt($ch, CURLOPT_REFERER, !empty($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : "");
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);
		$result = curl_exec($ch);
		curl_close($ch);
		return $result;
	}

	private static function parseResponse($response)
	{
		$result = json_decode($response);
		if ($result->responseStatus !== 200)
		{
			echo GWF_HTML::err('ERR_GENERAL', array(__FILE__, __LINE__));
			return false;
		}
		return $result->responseData->translatedText;
	}

	#######################
	### Detect Language ###
	#######################
	public static function detectLanguage($text)
	{
		$keyString = '';
		if (self::API_KEY !== '')
		{
			$keyString = '&key='.urlencode(self::API_KEY);
		}
		$url = sprintf('%s?v=%s%s&q=%s&userip=%s', self::URL_DETECT, self::VERSION, $keyString, urlencode($text), $_SERVER['REMOTE_ADDR']);
		return self::parseResponseDetect(self::curlRequestDetect($url));
	}

	private static function curlRequestDetect($url)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//		curl_setopt($ch, CURLOPT_REFERER, !empty($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : "");
		$result = curl_exec($ch);
		curl_close($ch);
		return $result;
	}

	private static function parseResponseDetect($response)
	{
		$result = json_decode($response);
		if ($result->responseStatus !== 200)
		{
			return GWF_HTML::err('ERR_GENERAL', array(__FILE__, __LINE__));
		}
		return $result->responseData->language;
	}

}
