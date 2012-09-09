<?php

if(!isset($_HEADER))
{
	$_HEADER = array();
	global $_HEADER;
}

if (false === function_exists('http_response_code'))
{
	function http_response_code($code)
	{
		//header(sprintf('%s %d %s', Common::getProtocol(), $code, $status));
		header(':', true, $code);
	}
}

/**
 * tools for getting and setting http headers
 * @author spaceone
 */
final class GWF_HTTPHeader
{
	private static $HEADERS;

	/**
	 *
	 * get request headers
	 */
	public static function getHeaders()
	{
		if (!isset(self::$HEADERS))
		{
			self::$HEADERS = headers_list();
			if(PHP_SAPI === 'cli')
			{
				global $_HEADER;
				if(is_array($_HEADER))
				{
					self::$HEADERS = $_HEADER;
				}
			}
			array_map('strtolower', self::$HEADERS);
		}
		return self::$HEADERS;
	}

	/**
	 * get a request header
	 * 
	 */
	public static function getHeader($header, $default=false)
	{
		$header = strtolower($header);
		return (isset(self::$HEADERS[$header])) ? self::$HEADERS[$header] : $default;
	}

	/**
	 * set response headers
	 */
	public static function setHeaders($headers)
	{
		$ret = true;
		foreach ($headers as $key => $val)
		{
			$header = array($key, $val);
			if (is_numeric($key))
			{
				$header = $val;
			}
			$ret = $ret && self::setHeader($header);
		}
		return $ret;
	}

	/*
	 *
	 * @param string|array $header
	 */
	public static function setHeader($header, $replace=true)
	{
		if (!is_array($header)) {
			$header = array_map('trim', explode(':', $header, 2));
		}
		list($key, $val) = $header;

		if(!headers_sent() || PHP_SAPI === 'cli')
		{
			global $_HEADER;
			if (!$replace && isset($_HEADER[$key]))
			{
				if ($_HEADER[$key] !== $val)
				{
					$_HEADER[$key] = array($_HEADER[$key], $val);
				}
			}
			else
			{
				$_HEADER[$key] = $val;
			}
		}
		if (!headers_sent())
		{
			header(sprintf('%s: %s', $key, $val), $replace);
			return true;
		}
		return PHP_SAPI === 'cli';
	}
 
	/**
	 * remove response headers
	 *
	 */
	public static function removeHeaders($headers)
	{
		$ret = true;
		foreach ((array) $headers as $header)
		{
			$ret = $ret && self::removeHeader($header);
		}
		return $ret;
	}

	public static function removeHeader($header)
	{
		global $_HEADER;
		unset($_HEADER[$header]);
		if (!headers_sent())
		{
			header_remove($header);
			return true;
		}
		return PHP_SAPI === 'cli';
	}

	/**
	 * Set HTTP status code
	 * @param int $code
	 */
	public static function statuscode($code)
	{
		return http_response_code($code);
	}

	/**
	 * HTTP Redirect
	 * @param int $code 3xx
	 * @param string $url redirection target
	 */
	public static function redirect($code, $url)
	{
		self::statuscode($code);
		self::setHeaders('Location: ' . $url);
	}

}

GWF_HTTPHeader::getHeaders();
