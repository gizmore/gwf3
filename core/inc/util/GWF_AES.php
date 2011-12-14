<?php
/**
 * GWF Helper/Wrapper for AES-256 encryption.
 * @author gizmore
 */
final class GWF_AES
{
	const IV = 'MyHomeIsMyCastle'; # <-- 16 chars
	const MODE = MCRYPT_MODE_CBC;
	const CIPHER = MCRYPT_RIJNDAEL_256;
	
	/**
	 * Encrypt with AES256 using the default IV.
	 * @param string $data
	 * @param string $key
	 */
	public static function encrypt($data, $key)
	{
		return self::encrypt4($data, $key, self::IV);
	}
	
	/**
	 * Encrypt with AES256. Use md5($iv) as IV.
	 * @param string $data
	 * @param string $key
	 * @param string $iv
	 * @return string data
	 */
	public static function encrypt4($data, $key, $iv)
	{
		return mcrypt_encrypt(self::CIPHER, $key, $data, self::MODE, md5($iv));
	}
	
	
	/**
	 * Decrypt with AES256 using the default IV.
	 * @param string $data
	 * @param string $key
	 */
	public static function decrypt($data, $key)
	{
		return self::decrypt4($data, $key, self::IV);
	}
	
	/**
	 * Decrypt with AES256. Use md5($iv) as IV.
	 * @param string $data
	 * @param string $key
	 * @param string $iv
	 * @return string data
	 */
	public static function decrypt4($data, $key, $iv)
	{
		return mcrypt_decrypt(self::CIPHER, $key, $data, self::MODE, md5($iv));
	}
}
?>