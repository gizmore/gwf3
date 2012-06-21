<?php
/**
 * GWF Helper/Wrapper for AES-256 encryption.
 * @author gizmore
 */
final class GWF_AES
{
	const IV = 'MyHomeIsMyCastleIamhungrywhereisi'; # <-- 32 chars
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
	 * Encrypt with AES256. Use sha256($iv) as IV. It is recommended to call this with a funny IV over the above.
	 * @param string $data
	 * @param string $key
	 * @param string $iv
	 * @return string data
	 */
	public static function encrypt4($data, $key, $iv)
	{
		return mcrypt_encrypt(self::CIPHER, $key, $data, self::MODE, hash('SHA256', $iv, true));
	}

	/**
	 * Encrypt with AES256. Use sha256($password) as key. Use a random IV and prepend to the output.
	 * This is probably the function you are looking for.
	 * @param string $data
	 * @param string $password
	 * @return string data
	 */
	public static function encryptIV($data, $password)
	{
		$iv_size = mcrypt_get_iv_size(self::CIPHER, self::MODE);
		$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
		$key = hash('SHA256', $password, true);
		return base64_encode($iv).mcrypt_encrypt(self::CIPHER, $key, $data, self::MODE, $iv);
	}
	
	/**
	 * Decrypt data encrypted with with the encryptIV function above.
	 * @param string $data
	 * @param string $password
	 * @return string plaintext
	 */
	public static function decryptIV($data, $password)
	{
		$iv = substr($data, 0, 44);
		$key = hash('SHA256', $password, true);
		return mcrypt_decrypt(self::CIPHER, $key, substr($data, 44), self::MODE, base64_decode($iv));
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
	 * Decrypt with AES256. Use sha256($iv) as IV.
	 * @param string $data
	 * @param string $key
	 * @param string $iv
	 * @return string data
	 */
	public static function decrypt4($data, $key, $iv)
	{
		return mcrypt_decrypt(self::CIPHER, $key, $data, self::MODE, hash('SHA256', $iv, true));
	}
}
