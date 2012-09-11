<?php

if (false === function_exists('http_response_code'))
{
	function http_response_code($code=NULL)
	{
		if ($code === NULL)
		{
			return GWF_HTTPHeader::$status;
		}
		//header(sprintf('%s %d %s', Common::getProtocol(), $code, $status));
		header(':', true, $code);
		GWF_HTTPHeader::$status = $code;
		return $code;
	}
}

if (false === function_exists('getallheaders'))
{
	function getallheaders() { return array(); }
}

if (false === function_exists('apache_request_headers'))
{
	function apache_request_headers() { return getallheaders(); }
}

if (false === function_exists('apache_response_headers'))
{
	function apache_response_headers()
	{
		$response = array();
		$headers = headers_list();
		foreach($headers as $header)
		{
			list($key, $val) = array_map('trim', explode(':', $header, 2));
			$response[$key] = $val;
		}
		return $response;
	}
}

if(!isset($_HEADER))
{
	# A global variable containing all response header (needet for CLI)
	$_HEADER = apache_response_headers();
	global $_HEADER;
}

if(!isset($_REQUEST_HEADER))
{
	# a global variable containing request header (needet for CLI)
	$_REQUEST_HEADER = array();
	global $_REQUEST_HEADER;
}

/**
 * tools for getting and setting http headers
 * @author spaceone
 */
final class GWF_HTTPHeader
{
	private static $HEADERS;
	public static $status = 200;

	/**
	 *
	 * get request headers
	 */
	public static function getHeaders()
	{
		if (!isset(self::$HEADERS))
		{
			self::$HEADERS = getallheaders();
			if(PHP_SAPI === 'cli')
			{
				global $_REQUEST_HEADER;
				if(is_array($_REQUEST_HEADER))
				{
					self::$HEADERS = $_REQUEST_HEADER;
				}
			}
			self::$HEADERS = array_map('strtolower', self::$HEADERS);
		}
		return self::$HEADERS;
	}

	public static function getResponseHeaders()
	{
		global $_HEADER;
		return $_HEADER;
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
				# section 4.2 of RFC 2616
				$_HEADER[$key] = implode(',', array($_HEADER[$key], $val));
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
	public static function statuscode($code=NULL)
	{
		if (NULL !== $code)
		{
			self::$status = $code;
		}
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
