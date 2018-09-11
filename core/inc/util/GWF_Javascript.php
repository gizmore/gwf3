<?php
/**
 * Javascript helper functions.
 * Currently here is only some js http stream for gecko/mozilla browsers.
 * Also there is a helper function to convert arrays.
 * @author gizmore
 *
 */
final class GWF_Javascript
{
	###################
	### HTTP Stream ###
	###################
	/**
	 * Boundary magic string
	 * @var string
	 */
	const BOUNDARY = 'ENDOFSECTION';

	/**
	 * Start http stream.
	 * @return unknown_type
	 */
	public static function streamHeader()
	{
		$boundary = self::BOUNDARY;
		GWF_HTTP::noCache();
		header("Content-type: multipart/x-mixed-replace;boundary=$boundary");
		echo "--$boundary\r\n";
	}

	/**
	 * Start new section
	 * @param $type
	 * @return unknown_type
	 */
	public static function newSection($type='text/plain')
	{
		if (0 === ob_get_level()) {
			ob_start();
		}
		print "Content-type: $type\r\n\r\n";
	}

	/**
	 * End section.
	 * @param boolean $last
	 * @return void
	 */
	public static function endSection($last=false)
	{
		$boundary = self::BOUNDARY;
		echo $last ? "\r\n--$boundary--\r\n" : "\r\n--$boundary\r\n";
		self::flush();
	}

	/**
	 * Flush the stream.
	 * @return unknown_type
	 */
	public static function flush()
	{
		if (ob_get_length())
		{
			ob_end_flush();
			flush();
		}
		if (0 === ob_get_level()) {
			ob_start();
		}
	}

	############
	### Util ###
	############

	/**
	 * Convert a php array to a javascript sourcecode array.
	 * @param array $array
	 * @return string
	 */
	public static function toJavascriptArray(array $array)
	{
		$back = '';
		foreach ($array as $e)
		{
			if (is_string($e)) {
				$back .= sprintf(', "%s"', str_replace('"', '\\"', $e));
			}
			else if (is_integer($e) || is_double($e) || is_float($e)) {
				$back .= sprintf(', %s', (string)$e);
			}
			else {
				die('Can not convert Array to JS Array !');
			}
		}
		if ($back !== '') {
			$back = substr($back, 2);
		}
		return sprintf('new Array(%s)', $back);
	}

	#############
	### Focus ###
	#############
	/**
	 * Focus an element onload.
	 * @see focusElementByName
	 * @param string $id
	 * @return void
	 */
	public static function focusElementByID($id)
	{
		static $called = false;
		if (!$called)
		{
			GWF_Website::addJavascriptOnload("var e = document.getElementById('$id'); (e !== null) { e.focus(); };");
			$called = true;
		}
	}

	/**
	 * Focus an element onload.
	 * @see focusElementByID
	 * @param string $name
	 * @return void
	 */
	public static function focusElementByName($name)
	{
		static $called = false;
		if (!$called)
		{
			$focus_script = "var e = document.getElementsByName('$name'); if (e.length === 1) { e[0].focus(); };";
			GWF_Website::addJavascriptOnload($focus_script);
			$called = true;
		}
	}
}

