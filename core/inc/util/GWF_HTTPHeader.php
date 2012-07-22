<?php

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
		foreach ((array) $headers as $key => $val)
		{
			# TODO: key/value dict?
			header($val);
		}
	}
 
	/**
	 * remove response header
	 *
	 */
	public static function removeHeaders($headers)
	{
		foreach ((array) $headers as $header)
		{
			header_remove($header);
		}
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
