<?php
/**
 * Validation functions.
 * @author gizmore
 */
final class GWF_Validator
{
	public static function isValidURL($url, $maxlen=255)
	{
		if (Common::startsWith($url, '/')) {
			return true;
		}
		return preg_match("/^[a-zA-Z]+[:\/\/]+[A-Za-z0-9\-_]+\\.+[A-Za-z0-9\.\/%&=\?\-_]+$/iD", $url) === 1;
	}

//	public static function filterURL($url, $maxlen=255)
//	{
//		if (false === ($pos = strpos($url, '://'))) {
//			return 'http://'.$url;
//		}
//		$protocol = strtolower(substr($url, 0, $pos));
////		$urlpart = substr($url, $pos+3);
//		static $allowed = array('http', 'https', 'ftp', 'ftps', 'irc', 'ircs');
//		if (!in_array($protocol, $allowed, true)) {
//			return false;
//		}
//		return $url;
//	}

	/**
	 * Is most likely a valid email?
	 * @param $email string
	 * @param $maxlen optional int
	 * @return boolean
	 */
	public static function isValidEmail($email, $maxlen=255)
	{
		if (strlen($email) > $maxlen) {
			return false;
		}
		//from: http://www.regular-expressions.info/email.html
		return preg_match('/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i', $email) > 0;
	}

	public static function isValidUsername($name, $maxlength=28, $minlength=3, $allowChars='')
	{
		//this one returns true is the username starts with at least 1 [a-zA-Z0-9] and ends with a single [a-zA-Z\_ 0-9]  
		//return preg_match('/^([a-zA-Z0-9])+([a-zA-Z\_ 0-9])$/' , $name);
		// this one is more simple
		$len = GWF_String::strlen($name);
		if ($len > $maxlength || $len < $minlength)
		{
			return false; # check limits
		}
		# return a-z then a-z_0-9
		return preg_match('/^[a-z][-a-z0-9_'.$allowChars.']+$/iD', $name) === 1;
	}

	/**
	 * Does a password match security policies?
	 * @param $password string
	 * @param $minlen [optional] int
	 * @return boolean
	 */
	public static function isValidPassword($password, $minlen=6)
	{
		return strlen($password) >= $minlen;
	}

	# returns true if the mobile looks valid
	public static function isValidMobile(string $mobile)
	{
		return preg_match('#^[1-9]{1}[0-9]{8,12}$#D', $mobile) > 0;
	}

	/**
	 * Make an url harmless by prefixing a protocol.
	 * prefix url with http:// if no protocol given.
	 * Recognized protocols are http and https.
	 */
//	public static function validateURL($url)
//	{
//		if (stripos($url, "https://") === 0) {
//			return $url;
//		}
//		
//		if (stripos($url, "http://") !== 0) {
//			$url = "http://".$url;
//		}
//
//		return $url;
//	}

	/**
	 * Check if input is valid md5.
	 * @return true if $string is 32 char md5. */
//	public static function isMD5($string)
//	{
//		return preg_match('/^[a-f0-9]{32}$/iD', $string) === 1;
//	}

//	public static function isValidDate($date, $allowBlank=false, $length=8)
//	{
//		return GWF_Time::isValidDate($date, $allowBlank, $length);
//	}

	public static function isOctalNumber($string)
	{
//		if (is_array($string) || is_object($string))
//		{
//			return false;
//		}
		return preg_match('/^[0-7]+$/D', $string) === 1;
	}

	public static function isDecimalNumber($string)
	{
//		if (is_array($string) || is_object($string))
//		{
//			return false;
//		}
		return preg_match('/^\d+$/D', $string) === 1;
	}

	public static function isHexNumber($string)
	{
//		if (is_array($string) || is_object($string))
//		{
//			return false;
//		}
		return preg_match('/^[0-9A-F+$/iD', $string) === 1;
	}

	##########################
	### Default Validators ###
	##########################
	public static function validateString($m, $key, $arg, $min=0, $max=63, $unset=true, $reduced_ascii_only=false)
	{
		$_POST[$key] = $arg = trim($arg);
		$len = GWF_String::strlen($arg);
		if ($len < $min || $len > $max) {

			if ($unset === true) {
				$_POST[$key] = '';
			} elseif ($unset !== false) {
				$_POST[$key] = $unset;
			}
			return $m->lang('err_'.$key, array($min, $max)); // FIXME: {gizmore} if lang is not loaded it will ends up in FATAL
		}
		
		if ($reduced_ascii_only)
		{
			if (!preg_match('/^[-a-z0-9_]*$/iD', $arg))
			{
				return $m->lang('err_'.$key, array($min, $max));
			}
		}
		
		return false;
	}

	public static function validateFilename($m, $key, $arg, $unset=true, $max=63)
	{
		$_POST[$key] = $arg = trim($arg);
		if (1 !== preg_match("/^[a-zA-Z0-9\.\-_ ]{1,$max}$/D", $arg))
		{
			switch ($unset)
			{
				case false: break;
				case true: $unset = '';
				default: $_POST[$key] = $unset;
			}
			return $m->lang('err_'.$key, array($max));
		}
		return false;
	}

	public static function validateClassname($m, $key, $arg, $min=0, $max=63, $unset=true)
	{
		$_POST[$key] = $arg = trim($arg);
		$len = GWF_String::strlen($arg);
		if ($len < $min || $len > $max || 0 === preg_match('/^[a-zA-Z][A-Za-z_0-9]+$/D', $arg))
		{
			if ($unset)
			{
				$_POST[$key] = '';
			}
			return $m->lang('err_'.$key, array($min, $max));
		}
		return false;
	}

	/**
	 * Validator for the username field.
	 * @param GWF_Module $m
	 * @param string $key the $_POST[$key]
	 * @param string $arg submitted value
	 * @param boolean $unset unset when error?
	 * @param string $allowChars additional allowed chars
	 * @return false|string on error
	 */
	public static function validateUsername($m, $key, $arg, $unset=true, $allowChars='')
	{
		$_POST[$key] = $arg = trim($arg);
		if (true === self::isValidUsername($arg, GWF_User::USERNAME_LENGTH, 3, $allowChars)) {
			return false;
		}
		if ($unset !== false) {
			if ($unset === true) {
				$_POST[$key] = '';
			} else {
				$_POST[$key] = $unset;
			}
		}
		return $m->lang('err_'.$key, array(3, GWF_User::USERNAME_LENGTH));
	}

	/**
	 * Validate a group ID.
	 * @param GWF_Module $m
	 * @param $key
	 * @param $arg
	 * @param boolean $unset
	 * @param boolean $allow_zero
	 */
	public static function validateGroupID($m, $key, $arg, $unset=true, $allow_zero=false)
	{
		$_POST[$key] = $arg = trim($arg);

		if ($allow_zero && $arg == 0) {
			$arg = '0';
			return false;
		}

		if (false !== (GWF_Group::getByID($arg))) {
			return false;
		}
		if ($unset) {
			unset($_POST[$key]);
		}
		return $m->lang('err_'.$key, array(3, GWF_Group::NAME_LEN));
	}

	public static function validateUserID($arg, $allow_zero=false, $key='userid', $unset=false)
	{
		if ($allow_zero && $arg == 0) {
			return false;
		}
		if (false !== ($user = GWF_User::getByID($arg))) {
			return false;
		}
		if ($unset) {
			unset($_POST[$key]);
		}
		return GWF_HTML::err('ERR_UNKNOWN_USER'); 
	}

	public static function validateInt($m, $key, $arg, $min='0', $max="2000000000", $unset=true)
	{
		$_POST[$key] = $arg = trim($arg); 
		$len = strlen($arg);
		for($i = 0; $i < $len; $i++)
		{
			if ($arg{$i}<'0' || $arg{$i}>'9') {
				if (is_string($unset)) {
					$_POST[$key] = $unset;
				}
				elseif ($unset) {
					$_POST[$key] = '';
				}
				return $m->lang('err_'.$key, array($min, $max));
			}
		}
//		intval($arg, 10);
//		if ($arg < $min || $arg > $max) {
		if ( (bccomp("$arg", "$min")<0) || (bccomp("$arg", "$max")>0) ) {
			if ($unset) {
				$_POST[$key] = '';
			}
			return $m->lang('err_'.$key, array($min, $max));
		}
		return false;
	}

	public static function validateDecimal($m, $key, $arg, $min=0, $max=PHP_INT_MAX, $unset=true)
	{
		if (!is_numeric($arg)) {
			return $m->lang('err_'.$key, array($min, $max));
		}
		$_POST[$key] = $arg = floatval($arg);
		if ($arg < $min || $arg > $max) {
			if ($unset !== false) {
				$_POST[$key] = $unset;
			}
			return $m->lang('err_'.$key, array($min, $max));
		}
		return false;
	}

	public static function validateEMail($m, $key, $arg, $unset=true, $allow_empty=false)
	{
		$_POST[$key] = $arg = trim($arg);

		if ($allow_empty && $arg === '') {
			return false;
		}

		if (!GWF_Validator::isValidEmail($arg)) {
			if ($unset) {
				$_POST[$key] = '';
			}
			return $m->lang('err_'.$key);
		}
		return false;
	}

	public static function validateURL($m, $key, $arg, $allow_empty=false, $unset=true)
	{
		$_POST[$key] = $arg = trim($arg);

		if ($arg === '' && $allow_empty === true)
		{
			return false;
		}

		if (GWF_HTTP::pageExists($arg))
		{
			return false;
		}

		# Unset
		if ($unset === true) { $_POST[$key] = ''; }
		elseif ($unset !== false) { $_POST[$key] = $unset; }

		# return error msg
		return $m->lang('err_'.$key);
	}

	public static function validateDate($m, $key, $arg, $datelen, $allow_zero=true, $unset=true)
	{
		$_POST[$key] = $arg = trim($arg);
		if (!GWF_Time::isValidDate($arg, $allow_zero, $datelen)) {
			if($unset) {
				$_POST[$key] = '';
			}
			return $m->lang('err_'.$key);
		}
		return false;
	}

	public static function validateTime($m, $key, $arg, $allow_zero=true, $unset=true)
	{
		if (!GWF_TimeSelect::isValidTime($arg, $allow_zero))
		{
			if ($unset)
			{
				unset($_POST[$key.'h']);
				unset($_POST[$key.'i']);
			}
			return $m->lang('err_'.$key);
		}
		return false;
	}

	public static function validateTags($m, $key, $arg, $minlen=3, $maxlen=32)
	{
		$tags = explode(',', $arg);
		$min = $minlen-1;
		$max = $maxlen-1;
		$taken = array();
		foreach ($tags as $tag)
		{
			if ('' === ($tag = trim($tag))) {
				continue;
			}

			if (preg_match('/^[a-zA-Z]{1}[a-zA-Z0-9]{'.$min.','.$max.'}$/D', $tag) !== 1)
			{
				return $m->lang('err_'.$key);
			}
			$taken[] = $tag;
		}
		$_POST[$key] = implode(',', $tags);
		return false;
	}
}


