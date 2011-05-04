<?php
/**
 * Passwords, Tokens, Random
 * @author gizmore
 */
final class GWF_Password
{
	const SECRET_SALT = GWF_SECRET_SALT; # any string will do. (this is just a lengthener, good length is maybe 8 or 12)
	const SALTLEN = 4; // real random salt len
	const SHA1LEN = 40; // hash len (currently sha1)
	const HASHLEN = 44; // total hash len (hash+salt)
	const TOKEN_LEN= 16;
	
	################
	### Password ###
	################
	/**
	 * Strong Hashing function. using unique salt, dynamic salt and a rather strong algorithm.
	 * @param $string
	 * @return string salted SHA1 hash
	 */
	public static function hashPasswordS($password)
	{
		$salt = Common::randomKey(self::SALTLEN); // Generate random salt.
		return self::hashSHA1(self::SECRET_SALT.$password.$salt.self::SECRET_SALT).$salt; 
	}
	
	public static function checkPasswordS($password, $hash)
	{
		$salt = substr($hash, -self::SALTLEN);
		return self::hashSHA1(self::SECRET_SALT.$password.$salt.self::SECRET_SALT) === substr($hash, 0, self::SHA1LEN);
	}
	
	public static function hashSHA1($string)
	{
		return hash('sha1', $string);
	}
	
	##############
	### Tokens ###
	##############
	public static function hashCRC32($string)
	{
		return hash('crc32', $string);
	}
	
	public static function getToken($data)
	{
		return substr(md5($data.self::SECRET_SALT.$data.self::SECRET_SALT), 1, self::TOKEN_LEN);
	}
	
	public static function md5($data)
	{
		return md5(self::SECRET_SALT.$data.self::SECRET_SALT);
	}
	
	###################
	### ClearMemory ###
	###################
	public static function clearMemory($key='password')
	{
		$clr = str_repeat('x', strlen($_REQUEST[$key]));
		if (isset($_GET[$key])) { $_GET[$key]=$clr; }
		if (isset($_POST[$key])) { $_POST[$key]=$clr; }
		if (isset($_REQUEST[$key])) { $_REQUEST[$key]=$clr; }
	}
}
?>